<?php

namespace App\Console\Commands;

use App\Actions\ReleaseStockAction;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically expire unpaid orders that have passed their deadline';

    /**
     * Execute the console command.
     */
    public function handle(ReleaseStockAction $releaseStockAction)
    {
        $this->info('Starting ExpireOrders command...');

        // Find orders where:
        // expired_at <= now()
        // AND status_order = pending
        // AND status_payment IN (belum_bayar, menunggu_validasi)
        $orders = Order::where('expired_at', '<=', now())
            ->where('status_order', OrderStatus::Pending)
            ->whereIn('status_payment', [
                PaymentStatus::BelumBayar,
                PaymentStatus::MenungguValidasi,
            ])
            ->get();

        if ($orders->isEmpty()) {
            $this->info('No expired orders found.');
            return;
        }

        $expiredCount = 0;
        $invoices = [];

        foreach ($orders as $order) {
            DB::transaction(function () use ($order, $releaseStockAction, &$expiredCount, &$invoices) {
                // Double check status inside transaction in case of race condition
                $freshOrder = Order::where('id_order', $order->id_order)
                    ->where('status_order', OrderStatus::Pending)
                    ->lockForUpdate()
                    ->first();

                if (!$freshOrder) {
                    return; // Already processed by another process
                }

                $freshOrder->update([
                    'status_order' => OrderStatus::Batal,
                    'status_payment' => PaymentStatus::Expired,
                ]);

                // Stock Restoration
                // Currently QRIS statis does not reduce stock on checkout,
                // so this action may do nothing, but prepares for dynamic payment.
                $releaseStockAction->execute($freshOrder);

                $expiredCount++;
                $invoices[] = $freshOrder->no_invoice;

                Log::info('Order automatically expired', [
                    'no_invoice' => $freshOrder->no_invoice,
                    'id_order'   => $freshOrder->id_order,
                    'expired_at' => $freshOrder->expired_at->toDateTimeString(),
                ]);

                app(\App\Contracts\NotificationServiceInterface::class)->sendOrderExpired($freshOrder);
            });
        }

        $this->info("Successfully expired {$expiredCount} orders.");
        
        Log::info('ExpireOrders command completed', [
            'total_expired' => $expiredCount,
            'invoices'      => $invoices,
        ]);
    }
}
