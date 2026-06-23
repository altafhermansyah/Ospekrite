<x-storefront-layout :title="'Pembayaran Berhasil — ' . $order->no_invoice" :cartCount="$cartCount">

    <x-slot name="styles">
        <style>
            /* ---- Page Wrapper ---- */
            .sukses-wrapper {
                padding: 50px 0 80px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                max-width: 540px;
                margin: 0 auto;
            }

            /* ---- Animated Confetti Ring ---- */
            .success-ring-outer {
                position: relative;
                width: 116px;
                height: 116px;
                margin-bottom: 28px;
            }

            .success-ring-pulse {
                position: absolute;
                inset: -10px;
                border-radius: 50%;
                background: #dcfce7;
                animation: pulse-ring 2s ease-out infinite;
                z-index: 0;
            }

            @keyframes pulse-ring {
                0%   { transform: scale(0.92); opacity: 0.7; }
                50%  { transform: scale(1.06); opacity: 0.25; }
                100% { transform: scale(0.92); opacity: 0.7; }
            }

            .success-icon-ring {
                position: relative;
                z-index: 1;
                width: 116px;
                height: 116px;
                border-radius: 50%;
                background: linear-gradient(135deg, #22c55e, #16a34a);
                display: flex;
                align-items: center;
                justify-content: center;
                animation: pop 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) both;
                box-shadow: 0 8px 24px rgba(22, 163, 74, 0.35);
            }

            @keyframes pop {
                0%   { transform: scale(0); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }

            .success-icon-ring i {
                font-size: 3.2rem;
                color: #fff;
            }

            /* ---- Typography ---- */
            .sukses-title {
                font-size: 1.7rem;
                font-weight: 800;
                color: var(--text-dark);
                margin-bottom: 8px;
            }

            .sukses-subtitle {
                color: var(--text-muted);
                font-size: 0.95rem;
                line-height: 1.75;
                margin-bottom: 30px;
            }

            /* ---- Invoice Box (prominent) ---- */
            .invoice-display-box {
                width: 100%;
                background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                border: 2px solid #86efac;
                border-radius: 16px;
                padding: 22px 28px;
                margin-bottom: 20px;
                position: relative;
                overflow: hidden;
            }

            .invoice-display-box::before {
                content: '';
                position: absolute;
                top: -30px; right: -30px;
                width: 120px; height: 120px;
                background: rgba(134, 239, 172, 0.25);
                border-radius: 50%;
            }

            .invoice-display-label {
                font-size: 0.72rem;
                color: #15803d;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                font-weight: 700;
                margin-bottom: 6px;
                position: relative;
            }

            .invoice-display-number {
                font-family: 'Courier New', monospace;
                font-size: 1.7rem;
                font-weight: 800;
                color: #15803d;
                letter-spacing: 0.04em;
                position: relative;
            }

            .invoice-display-note {
                font-size: 0.78rem;
                color: #166534;
                margin-top: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 5px;
                position: relative;
            }

            /* Copy button */
            .btn-copy-invoice {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                margin-top: 12px;
                padding: 7px 16px;
                background: #fff;
                border: 1px solid #86efac;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #16a34a;
                cursor: pointer;
                transition: background 0.15s, color 0.15s;
                position: relative;
            }

            .btn-copy-invoice:hover {
                background: #16a34a;
                color: #fff;
            }

            /* ---- Total Box ---- */
            .total-display-box {
                width: 100%;
                background: #fff;
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 16px 24px;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .total-display-label {
                font-size: 0.85rem;
                color: var(--text-muted);
            }

            .total-display-value {
                font-size: 1.2rem;
                font-weight: 800;
                color: var(--primary);
            }

            /* ---- Info Steps ---- */
            .info-steps {
                width: 100%;
                background: #eff6ff;
                border: 1px solid #bfdbfe;
                border-radius: 12px;
                padding: 18px 22px;
                margin-bottom: 24px;
                text-align: left;
            }

            .info-steps-title {
                font-size: 0.88rem;
                font-weight: 700;
                color: #1e40af;
                margin-bottom: 12px;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .info-step-item {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                font-size: 0.85rem;
                color: #1d4ed8;
                margin-bottom: 8px;
                line-height: 1.55;
            }

            .info-step-item i { flex-shrink: 0; margin-top: 1px; }
            .info-step-item:last-child { margin-bottom: 0; }

            /* ---- Action Buttons ---- */
            .action-buttons {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .btn-track-order {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 15px;
                background: var(--primary);
                color: #fff;
                border-radius: 10px;
                font-weight: 700;
                font-size: 1rem;
                text-decoration: none;
                transition: background 0.2s, transform 0.1s;
                width: 100%;
            }

            .btn-track-order:hover { background: var(--primary-hover); transform: translateY(-1px); }
            .btn-track-order:active { transform: translateY(0); }

            .btn-whatsapp {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 13px;
                background: #16a34a;
                color: #fff;
                border-radius: 10px;
                font-weight: 600;
                font-size: 0.93rem;
                text-decoration: none;
                transition: background 0.2s;
                width: 100%;
            }

            .btn-whatsapp:hover { background: #15803d; }

            .btn-home {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 13px;
                background: transparent;
                color: var(--text-muted);
                border: 1px solid var(--border-color);
                border-radius: 10px;
                font-weight: 600;
                font-size: 0.92rem;
                text-decoration: none;
                transition: background 0.2s, color 0.2s;
                width: 100%;
            }

            .btn-home:hover {
                background: var(--bg-light);
                color: var(--text-dark);
            }

            /* ---- Copy toast ---- */
            .copy-toast {
                position: fixed;
                bottom: 24px;
                left: 50%;
                transform: translateX(-50%) translateY(20px);
                background: #1e293b;
                color: #fff;
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 0.85rem;
                font-weight: 600;
                opacity: 0;
                transition: opacity 0.25s, transform 0.25s;
                z-index: 9999;
                pointer-events: none;
                white-space: nowrap;
            }

            .copy-toast.show {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        </style>
    </x-slot>

    {{-- Copy Toast --}}
    <div id="copy-toast" class="copy-toast">
        <i class="bi bi-check-lg"></i> Nomor invoice disalin!
    </div>

    <main class="layout-container">
        <div class="sukses-wrapper">

            {{-- Animated Check Icon --}}
            <div class="success-ring-outer">
                <div class="success-ring-pulse"></div>
                <div class="success-icon-ring">
                    <i class="bi bi-check-lg"></i>
                </div>
            </div>

            {{-- Title & Subtitle --}}
            <h1 class="sukses-title">Bukti Berhasil Dikirim!</h1>
            <p class="sukses-subtitle">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>!<br>
                Bukti pembayaranmu sudah kami terima dan sedang diverifikasi oleh panitia.<br>
                Konfirmasi akan dilakukan dalam <strong>1×24 jam</strong>.
            </p>

            {{-- Invoice Display (prominent) --}}
            <div class="invoice-display-box">
                <div class="invoice-display-label">
                    <i class="bi bi-ticket-perforated"></i> Nomor Invoice Pesananmu
                </div>
                <div class="invoice-display-number" id="invoice-number">{{ $order->no_invoice }}</div>
                <div class="invoice-display-note">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>Simpan nomor ini! Kamu butuhkan untuk cek status pesanan</span>
                </div>
                <button class="btn-copy-invoice" onclick="copyInvoice()" type="button" id="btn-copy-invoice">
                    <i class="bi bi-clipboard"></i> Salin Nomor Invoice
                </button>
            </div>

            {{-- Total --}}
            <div class="total-display-box">
                <div class="total-display-label"><i class="bi bi-receipt"></i> Total yang ditransfer</div>
                <div class="total-display-value">Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</div>
            </div>

            {{-- Next Steps Info --}}
            <div class="info-steps">
                <div class="info-steps-title">
                    <i class="bi bi-list-check"></i> Apa yang terjadi selanjutnya?
                </div>
                <div class="info-step-item">
                    <i class="bi bi-1-circle-fill"></i>
                    <span>Panitia akan memverifikasi bukti transfermu dalam <strong>1×24 jam</strong>.</span>
                </div>
                <div class="info-step-item">
                    <i class="bi bi-2-circle-fill"></i>
                    <span>Setelah terverifikasi, status pesananmu berubah menjadi <strong>Diproses</strong>.</span>
                </div>
                <div class="info-step-item">
                    <i class="bi bi-3-circle-fill"></i>
                    <span>Pesananmu akan siap diambil di stand panitia <strong>OSPEK Amerta 2026</strong>.</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="action-buttons">
                <a href="{{ route('track.show', $order->no_invoice) }}"
                   class="btn-track-order"
                   id="btn-cek-status">
                    <i class="bi bi-search"></i> Cek Status Pesanan
                </a>

                @php
                    $waText = urlencode(
                        "Halo, saya sudah mengirim bukti pembayaran untuk pesanan OSPEK Amerta 2026.\n" .
                        "No. Invoice: {$order->no_invoice}\n" .
                        "Nama: {$order->nama_pembeli}\n" .
                        "Total: Rp " . number_format($order->total_tagihan, 0, ',', '.') . "\n\n" .
                        "Mohon konfirmasinya. Terima kasih!"
                    );
                @endphp
                <a href="https://wa.me/?text={{ $waText }}"
                   class="btn-whatsapp"
                   target="_blank"
                   rel="noopener noreferrer"
                   id="btn-share-wa">
                    <i class="bi bi-whatsapp"></i> Bagikan via WhatsApp
                </a>

                <a href="{{ route('home') }}"
                   class="btn-home"
                   id="btn-kembali-beranda">
                    <i class="bi bi-house"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </main>

    <script>
        function copyInvoice() {
            const invoice = document.getElementById('invoice-number').textContent.trim();
            navigator.clipboard.writeText(invoice).then(() => {
                const toast = document.getElementById('copy-toast');
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2200);

                const btn = document.getElementById('btn-copy-invoice');
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Disalin!';
                btn.style.background = '#16a34a';
                btn.style.color = '#fff';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-clipboard"></i> Salin Nomor Invoice';
                    btn.style.background = '';
                    btn.style.color = '';
                }, 2200);
            }).catch(() => {
                // Fallback for browsers without clipboard API
                const el = document.createElement('textarea');
                el.value = invoice;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
            });
        }
    </script>

</x-storefront-layout>
