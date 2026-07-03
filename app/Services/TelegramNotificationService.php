<?php

namespace App\Services;

use App\Contracts\NotificationServiceInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService implements NotificationServiceInterface
{
    private ?string $botToken;
    private ?string $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    private function sendMessage(string $text, string $invoice, string $customerName, string $whatsapp): void
    {
        if (empty($this->botToken) || empty($this->chatId)) {
            Log::warning('Telegram notification skipped: Bot token or chat ID is not configured.', [
                'invoice' => $invoice
            ]);
            return;
        }

        try {
            $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
            
            $response = Http::withoutVerifying()->post($url, [
                'chat_id' => $this->chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful()) {
                Log::info('Telegram notification sent successfully', [
                    'invoice' => $invoice,
                    'customer_name' => $customerName,
                    'whatsapp' => $whatsapp,
                    'timestamp' => now()->toISOString()
                ]);
            } else {
                Log::error('Telegram notification failed', [
                    'invoice' => $invoice,
                    'customer_name' => $customerName,
                    'whatsapp' => $whatsapp,
                    'response' => $response->body(),
                    'timestamp' => now()->toISOString()
                ]);
            }
        } catch (\Throwable $e) {
            // NEVER break the business flow
            Log::error('Telegram notification exception caught', [
                'invoice' => $invoice,
                'customer_name' => $customerName,
                'whatsapp' => $whatsapp,
                'message' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ]);
        }
    }

    public function sendOrderCreated(Order $order): void
    {
        $total = number_format($order->total_tagihan, 0, ',', '.');
        $text = "🛒 <b>ORDER BARU</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}\n\n"
              . "WA:\n{$order->no_whatsapp}\n\n"
              . "Total:\nRp {$total}\n\n"
              . "Status:\nBelum Bayar";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendPaymentUploaded(Order $order): void
    {
        $text = "📸 <b>BUKTI PEMBAYARAN BARU</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}\n\n"
              . "WA:\n{$order->no_whatsapp}\n\n"
              . "Status:\nMenunggu Validasi";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendPaymentVerified(Order $order): void
    {
        $text = "✅ <b>PEMBAYARAN DIVERIFIKASI</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}\n\n"
              . "Status:\nLunas";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendOrderReady(Order $order): void
    {
        $text = "📦 <b>PESANAN SIAP DIAMBIL</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendOrderCompleted(Order $order): void
    {
        $text = "🎉 <b>PESANAN SELESAI</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendOrderCancelled(Order $order): void
    {
        $text = "❌ <b>PESANAN DIBATALKAN</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }

    public function sendOrderExpired(Order $order): void
    {
        $text = "⏰ <b>PESANAN EXPIRED</b>\n\n"
              . "Invoice:\n<code>{$order->no_invoice}</code>\n\n"
              . "Nama:\n{$order->nama_pembeli}";
              
        $this->sendMessage($text, $order->no_invoice, $order->nama_pembeli, $order->no_whatsapp);
    }
}
