<x-storefront-layout title="Simulasi Pembayaran Dinamis - Ospekrite">
    <x-slot name="styles">
        <style>
            .mock-wrapper {
                padding: 60px 0 100px;
                max-width: 600px;
                margin: 0 auto;
            }
            .mock-card {
                background: #fff;
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 30px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }
            .mock-header {
                text-align: center;
                margin-bottom: 30px;
            }
            .mock-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 8px;
            }
            .mock-subtitle {
                color: var(--text-muted);
                font-size: 0.95rem;
            }
            .mock-details {
                background: var(--bg-light);
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 30px;
            }
            .mock-detail-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                font-size: 0.95rem;
            }
            .mock-detail-row:last-child {
                margin-bottom: 0;
                padding-top: 10px;
                border-top: 1px dashed var(--border-color);
                font-weight: 700;
                font-size: 1.1rem;
            }
            .mock-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
            .btn-mock {
                padding: 12px;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: opacity 0.2s;
                color: #fff;
            }
            .btn-mock:hover {
                opacity: 0.9;
            }
            .btn-success { background: #10b981; }
            .btn-failed { background: #ef4444; }
            .btn-expired { background: #f59e0b; }
            .btn-cancelled { background: #6b7280; }
        </style>
    </x-slot>

    <main class="layout-container mock-wrapper">
        <div class="mock-card">
            <div class="mock-header">
                <i class="bi bi-robot" style="font-size: 3rem; color: var(--primary);"></i>
                <h1 class="mock-title">Mock Payment Gateway</h1>
                <p class="mock-subtitle">Halaman ini adalah simulasi. Di production, pengguna akan melihat halaman Midtrans/Xendit yang asli.</p>
            </div>

            <div class="mock-details">
                <div class="mock-detail-row">
                    <span style="color: var(--text-muted);">Invoice</span>
                    <span style="font-weight: 600;">{{ $order->no_invoice }}</span>
                </div>
                <div class="mock-detail-row">
                    <span style="color: var(--text-muted);">Nama</span>
                    <span>{{ $order->nama_pembeli }}</span>
                </div>
                <div class="mock-detail-row">
                    <span style="color: var(--text-muted);">Status Saat Ini</span>
                    <span style="color: #f59e0b; font-weight: 600;">PENDING</span>
                </div>
                <div class="mock-detail-row">
                    <span>Total Tagihan</span>
                    <span style="color: var(--primary);">Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</span>
                </div>
            </div>

            <form action="{{ route('mock.payment.simulate', $order->no_invoice) }}" method="POST">
                @csrf
                <div class="mock-actions">
                    <button type="submit" name="status" value="SUCCESS" class="btn-mock btn-success">
                        <i class="bi bi-check-circle"></i> Simulasi Bayar Berhasil
                    </button>
                    <button type="submit" name="status" value="FAILED" class="btn-mock btn-failed">
                        <i class="bi bi-x-circle"></i> Simulasi Bayar Gagal
                    </button>
                    <button type="submit" name="status" value="EXPIRED" class="btn-mock btn-expired">
                        <i class="bi bi-clock-history"></i> Simulasi Kedaluwarsa
                    </button>
                    <button type="submit" name="status" value="CANCELLED" class="btn-mock btn-cancelled">
                        <i class="bi bi-slash-circle"></i> Simulasi Dibatalkan
                    </button>
                </div>
            </form>
            
            <p style="text-align: center; margin-top: 25px; font-size: 0.85rem; color: var(--text-muted);">
                Aksi di atas akan mengirimkan Webhook Callback palsu ke backend Ospekrite untuk memproses pesanan secara otomatis (mengubah status & memotong stok).
            </p>
        </div>
    </main>
</x-storefront-layout>
