<?php

namespace App\Actions;

use App\Exceptions\FileUploadException;
use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * UploadBuktiAction
 *
 * Handles the full static-QRIS payment upload flow inside a single DB::transaction().
 * Security guarantees:
 * - UUID-based filename: original filename is NEVER used or stored
 * - Storage::disk('public') for consistent path resolution
 * - Atomic DB update: pembayaran insert + orders.status_payment update in one transaction
 * - 'lunas' guard: re-upload is rejected if payment is already confirmed
 */
class UploadBuktiAction
{
    /**
     * @param  Order        $order   The order fetched by no_invoice (already validated to exist)
     * @param  string       $namaPengirim
     * @param  UploadedFile $file
     * @return Pembayaran   The created or updated Pembayaran record
     * @throws FileUploadException
     */
    public function execute(Order $order, string $namaPengirim, UploadedFile $file): Pembayaran
    {
        // Resolve status regardless of whether it's a PHP Enum or plain string
        $statusVal = $order->status_payment instanceof \BackedEnum
            ? $order->status_payment->value
            : (string) $order->status_payment;

        // STEP 2 — Guards: block uploads on final/locked states
        if ($statusVal === 'lunas') {
            throw new \RuntimeException('Pembayaran sudah dikonfirmasi. Tidak bisa upload ulang.');
        }

        if ($statusVal === 'expired') {
            throw new \RuntimeException('Waktu pembayaran sudah habis. Pesanan tidak aktif.');
        }

        // Note: 'menunggu_validasi' is intentionally ALLOWED here.
        // Users may re-upload if they uploaded the wrong image, even while awaiting review.
        // The old file is deleted and replaced atomically below.

        // STEP 3 — Generate UUID filename. Never trust original filename.
        $extension = $file->getClientOriginalExtension();
        $filename  = Str::uuid()->toString() . '.' . strtolower($extension);

        // STEP 4 — Store the file
        $stored = Storage::disk('public')->putFileAs('bukti_pembayaran', $file, $filename);

        if ($stored === false) {
            throw new FileUploadException('Gagal menyimpan file bukti transfer. Coba lagi.');
        }

        $storedPath = 'bukti_pembayaran/' . $filename;

        return DB::transaction(function () use ($order, $namaPengirim, $storedPath) {

            // STEP 5/6 — Check for existing pembayaran record (handles re-upload case)
            $existing = Pembayaran::where('id_order', $order->id_order)->first();

            if ($existing) {
                // Delete old file if it still exists
                if ($existing->bukti_transfer && Storage::disk('public')->exists($existing->bukti_transfer)) {
                    Storage::disk('public')->delete($existing->bukti_transfer);
                }

                // Update existing record
                $existing->update([
                    'nama_pengirim'     => $namaPengirim,
                    'bukti_transfer'    => $storedPath,
                    'status_pembayaran' => 'menunggu_validasi',
                    'waktu_bayar'       => Carbon::now(),
                ]);

                $pembayaran = $existing;
            } else {
                // STEP 6 — Insert new pembayaran record
                $pembayaran = Pembayaran::create([
                    'id_order'          => $order->id_order,
                    'id_metode'         => null, // Not tied to a specific metode_pembayaran row for QRIS Statis
                    'nama_pengirim'     => $namaPengirim,
                    'bukti_transfer'    => $storedPath,
                    'status_pembayaran' => 'menunggu_validasi',
                    'waktu_bayar'       => Carbon::now(),
                    'tipe_pembayaran'   => 'qris_statis',
                ]);
            }

            // STEP 7 — Update orders.status_payment atomically with the pembayaran insert
            $order->update([
                'status_payment' => 'menunggu_validasi',
            ]);

            $isReupload = (bool) $existing;
            Log::info($isReupload ? 'Payment proof re-uploaded' : 'Payment proof uploaded', [
                'id_order'   => $order->id_order,
                'no_invoice' => $order->no_invoice,
                'file'       => $storedPath,
                'is_reupload'=> $isReupload,
            ]);

            app(\App\Contracts\NotificationServiceInterface::class)->sendPaymentUploaded($order);

            return $pembayaran;
        });
    }
}
