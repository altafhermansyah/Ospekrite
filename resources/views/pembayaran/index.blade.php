<x-storefront-layout :title="'Pembayaran ' . $order->no_invoice" :cartCount="$cartCount">

    <x-slot name="styles">
        <style>
            /* ---- Page Layout ---- */
            .payment-wrapper {
                padding: 30px 0 60px;
                max-width: 860px;
                margin: 0 auto;
            }

            .payment-page-title {
                font-size: 1.5rem;
                font-weight: 700;
                margin-bottom: 4px;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .payment-page-subtitle {
                color: var(--text-muted);
                font-size: 0.9rem;
                margin-bottom: 28px;
            }

            /* ---- Cards ---- */
            .card-section {
                background: #fff;
                border-radius: 12px;
                border: 1px solid var(--border-color);
                padding: 24px 28px;
                margin-bottom: 20px;
                box-shadow: var(--shadow-sm);
            }

            .card-section-title {
                font-size: 1rem;
                font-weight: 700;
                margin-bottom: 18px;
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--text-dark);
                padding-bottom: 12px;
                border-bottom: 1px solid var(--border-color);
            }

            .card-section-title i {
                color: var(--primary);
            }

            /* ---- Order Info Grid ---- */
            .order-info-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            .order-info-item {
                display: flex;
                flex-direction: column;
                gap: 3px;
            }

            .order-info-label {
                font-size: 0.75rem;
                color: var(--text-muted);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                font-weight: 600;
            }

            .order-info-value {
                font-size: 0.95rem;
                font-weight: 600;
            }

            .order-info-value.invoice {
                font-family: 'Courier New', monospace;
                font-size: 1rem;
                color: var(--primary);
                font-weight: 700;
            }

            .order-info-value.total {
                font-size: 1.25rem;
                color: var(--success);
                font-weight: 700;
            }

            /* ---- Status Badge ---- */
            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
            }

            .status-belum-bayar   { background: #f3f4f6; color: #374151; }
            .status-menunggu      { background: #fef9c3; color: #854d0e; }
            .status-lunas         { background: #dcfce7; color: #166534; }
            .status-ditolak       { background: #fee2e2; color: #991b1b; }
            .status-expired       { background: #f3f4f6; color: #6b7280; }

            /* ---- Deadline bar ---- */
            .deadline-bar {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 12px 16px;
                background: #fff7ed;
                border: 1px solid #fdba74;
                border-radius: 8px;
                margin-top: 16px;
                font-size: 0.88rem;
                color: #9a3412;
            }

            .deadline-bar i {
                font-size: 1.1rem;
                flex-shrink: 0;
            }

            /* ---- Metode Pembayaran ---- */
            .metode-list {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .metode-card {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 14px 18px;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                background: var(--bg-light);
            }

            .metode-bank-name {
                font-weight: 700;
                font-size: 0.95rem;
                margin-bottom: 2px;
            }

            .metode-bank-detail {
                font-size: 0.85rem;
                color: var(--text-muted);
            }

            .metode-rekening {
                font-family: 'Courier New', monospace;
                font-size: 1rem;
                font-weight: 700;
                color: var(--primary);
                cursor: pointer;
            }

            .transfer-amount-box {
                margin-top: 16px;
                padding: 16px 20px;
                background: #eff6ff;
                border: 1px dashed #3b82f6;
                border-radius: 8px;
                text-align: center;
            }

            .transfer-amount-label {
                font-size: 0.8rem;
                color: var(--text-muted);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 4px;
            }

            .transfer-amount-value {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--primary);
            }

            .transfer-warning {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-top: 10px;
                font-size: 0.82rem;
                color: #92400e;
                background: #fffbeb;
                padding: 10px 14px;
                border-radius: 6px;
                border: 1px solid #fde68a;
            }

            /* ---- Upload Form ---- */
            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                margin-bottom: 6px;
                color: var(--text-dark);
            }

            .required { color: var(--danger); }

            .form-control {
                width: 100%;
                padding: 10px 14px;
                border: 1px solid var(--border-color);
                border-radius: var(--radius);
                font-size: 0.9rem;
                font-family: 'Inter', sans-serif;
                outline: none;
                transition: border-color 0.2s;
                background: #fff;
            }

            .form-control:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
            }

            .form-control.is-invalid {
                border-color: var(--danger);
            }

            .invalid-feedback {
                color: var(--danger);
                font-size: 0.8rem;
                margin-top: 4px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            /* ---- File Upload Area ---- */
            .file-upload-area {
                border: 2px dashed var(--border-color);
                border-radius: 10px;
                padding: 24px;
                text-align: center;
                cursor: pointer;
                transition: border-color 0.2s, background 0.2s;
                position: relative;
            }

            .file-upload-area:hover,
            .file-upload-area.drag-over {
                border-color: var(--primary);
                background: #f0f6ff;
            }

            .file-upload-area input[type="file"] {
                position: absolute;
                inset: 0;
                opacity: 0;
                cursor: pointer;
                width: 100%;
                height: 100%;
            }

            .file-upload-icon {
                font-size: 2rem;
                color: var(--text-muted);
                margin-bottom: 8px;
                display: block;
            }

            .file-upload-text {
                font-size: 0.875rem;
                color: var(--text-muted);
            }

            .file-upload-hint {
                font-size: 0.75rem;
                color: var(--text-muted);
                margin-top: 4px;
            }

            /* ---- Image Preview ---- */
            .img-preview-container {
                margin-top: 14px;
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid var(--border-color);
                background: var(--bg-light);
                text-align: center;
            }

            .img-preview {
                max-width: 100%;
                max-height: 280px;
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }

            /* ---- Submit Button ---- */
            .btn-submit-payment {
                width: 100%;
                background: var(--primary);
                color: #fff;
                border: none;
                padding: 16px;
                border-radius: 10px;
                font-weight: 700;
                font-size: 1.05rem;
                cursor: pointer;
                transition: background 0.2s, opacity 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                margin-top: 8px;
            }

            .btn-submit-payment:hover:not(:disabled) {
                background: var(--primary-hover);
            }

            .btn-submit-payment:disabled {
                opacity: 0.65;
                cursor: not-allowed;
            }

            /* ---- Spinner ---- */
            .spinner-icon {
                width: 18px;
                height: 18px;
                border: 2px solid rgba(255,255,255,0.35);
                border-top-color: #fff;
                border-radius: 50%;
                animation: spin 0.7s linear infinite;
                display: inline-block;
            }

            @keyframes spin { to { transform: rotate(360deg); } }

            /* ---- Alert Banners ---- */
            .alert-banner {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 14px 18px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 0.9rem;
            }

            .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
            .alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
            .alert-info    { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }

            /* ---- State Pages (expired, ditolak) ---- */
            .state-card {
                padding: 48px 32px;
                text-align: center;
            }

            .state-icon {
                font-size: 3.5rem;
                margin-bottom: 16px;
                display: block;
            }

            .state-title {
                font-size: 1.3rem;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .state-desc {
                color: var(--text-muted);
                font-size: 0.9rem;
                max-width: 400px;
                margin: 0 auto 24px;
                line-height: 1.6;
            }

            .btn-back-home {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 12px 28px;
                background: var(--primary);
                color: #fff;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                transition: background 0.2s;
            }

            .btn-back-home:hover { background: var(--primary-hover); }

            /* ---- Responsive ---- */
            @media (max-width: 600px) {
                .order-info-grid { grid-template-columns: 1fr; }
                .card-section { padding: 18px; }
            }
        </style>
    </x-slot>

    <main class="layout-container payment-wrapper" x-data="paymentForm()">

        {{-- Flash messages --}}
        @if(session('error'))
            <div class="alert-banner alert-error" role="alert">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="alert-banner alert-info" role="alert">
                <i class="bi bi-info-circle-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="alert-banner alert-error" role="alert">
                <i class="bi bi-exclamation-circle-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
                <div>
                    <strong>Periksa kembali form berikut:</strong>
                    <ul style="margin: 6px 0 0 16px; padding:0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <h1 class="payment-page-title">
            <i class="bi bi-qr-code"></i> Pembayaran
        </h1>
        <p class="payment-page-subtitle">Selesaikan pembayaranmu untuk memproses pesanan.</p>

        {{-- ============================================================
             SECTION 1: Order Info Card
        ============================================================ --}}
        <div class="card-section">
            <h2 class="card-section-title"><i class="bi bi-receipt"></i> Informasi Pesanan</h2>

            <div class="order-info-grid">
                <div class="order-info-item">
                    <span class="order-info-label">No. Invoice</span>
                    <span class="order-info-value invoice">{{ $order->no_invoice }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Status Pembayaran</span>
                    <span>
                        @php
                            $paymentStatusVal = $order->status_payment?->value ?? $order->status_payment;
                        @endphp
                        @if($paymentStatusVal === 'belum_bayar')
                            <span class="status-badge status-belum-bayar"><i class="bi bi-clock"></i> Belum Bayar</span>
                        @elseif($paymentStatusVal === 'menunggu_validasi')
                            <span class="status-badge status-menunggu"><i class="bi bi-hourglass-split"></i> Menunggu Validasi</span>
                        @elseif($paymentStatusVal === 'ditolak')
                            <span class="status-badge status-ditolak"><i class="bi bi-x-circle"></i> Ditolak</span>
                        @elseif($paymentStatusVal === 'expired')
                            <span class="status-badge status-expired"><i class="bi bi-slash-circle"></i> Kedaluwarsa</span>
                        @endif
                    </span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Nama Pemesan</span>
                    <span class="order-info-value">{{ $order->nama_pembeli }}</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Tanggal Pesanan</span>
                    <span class="order-info-value">
                        {{ $order->tanggal_order ? $order->tanggal_order->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
            </div>

            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                <div class="transfer-amount-box">
                    <div class="transfer-amount-label">Total yang harus ditransfer</div>
                    <div class="transfer-amount-value">Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</div>
                </div>
            </div>

            @if($order->expired_at)
                <div class="deadline-bar">
                    <i class="bi bi-alarm"></i>
                    <span>
                        Batas pembayaran: <strong>{{ $order->expired_at->format('d M Y, H:i') }} WIB</strong>
                        @if($order->expired_at->isFuture())
                            ({{ $order->expired_at->diffForHumans() }})
                        @endif
                    </span>
                </div>
            @endif
        </div>

        {{-- ============================================================
             STATE: Expired
        ============================================================ --}}
        @if($pageState === 'expired')
            <div class="card-section">
                <div class="state-card">
                    <span class="state-icon" style="color: #9ca3af;">⏰</span>
                    <div class="state-title" style="color: #374151;">Waktu Pembayaran Habis</div>
                    <p class="state-desc">
                        Batas waktu pembayaran untuk pesanan ini telah habis.
                        Pesananmu telah otomatis dibatalkan.
                    </p>
                    <a href="{{ route('home') }}" class="btn-back-home">
                        <i class="bi bi-house"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

        {{-- ============================================================
             STATE: Ditolak (re-upload allowed)
        ============================================================ --}}
        @elseif($pageState === 'ditolak')
            <div class="alert-banner alert-warning">
                <i class="bi bi-x-octagon-fill" style="font-size:1.1rem;flex-shrink:0;"></i>
                <div>
                    <strong>Bukti pembayaran ditolak.</strong><br>
                    <span style="font-size:0.875rem;">Silakan upload ulang bukti transfer yang valid.</span>
                </div>
            </div>
            {{-- Fall through to show payment methods + upload form --}}
            @include('pembayaran._payment_methods_and_form', ['metodePembayaran' => $metodePembayaran, 'order' => $order])

        {{-- ============================================================
             STATE: Menunggu Validasi (already uploaded, awaiting admin)
        ============================================================ --}}
        @elseif($pageState === 'form' && $order->pembayaran)
            <div class="alert-banner alert-info">
                <i class="bi bi-hourglass-split" style="font-size:1.1rem;flex-shrink:0;"></i>
                <div>
                    <strong>Bukti pembayaran sudah dikirim.</strong><br>
                    <span style="font-size:0.875rem;">Panitia sedang memverifikasi pembayaranmu. Harap tunggu 1×24 jam.</span>
                </div>
            </div>
            {{-- Show instructions but no form (already uploaded) --}}
            @include('pembayaran._payment_methods_only', ['metodePembayaran' => $metodePembayaran, 'order' => $order])

        {{-- ============================================================
             STATE: Form (belum bayar — needs to upload)
        ============================================================ --}}
        @else
            @include('pembayaran._payment_methods_and_form', ['metodePembayaran' => $metodePembayaran, 'order' => $order])
        @endif

    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentForm', () => ({
                isSubmitting: false,
                previewUrl:   null,
                fileName:     null,

                handleFileChange(event) {
                    const file = event.target.files[0];
                    if (!file) {
                        this.previewUrl = null;
                        this.fileName   = null;
                        return;
                    }
                    this.fileName = file.name;
                    const reader  = new FileReader();
                    reader.onload = (e) => { this.previewUrl = e.target.result; };
                    reader.readAsDataURL(file);
                },

                handleSubmit(e) {
                    if (this.isSubmitting) {
                        e.preventDefault();
                        return;
                    }
                    this.isSubmitting = true;
                },
            }));
        });
    </script>

</x-storefront-layout>
