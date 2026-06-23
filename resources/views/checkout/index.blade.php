<x-storefront-layout title="Checkout - Ospekrite">
    <x-slot name="styles">
        <style>
            /* =====================================================
               CHECKOUT PAGE — Stage 5A
               ===================================================== */

            .checkout-wrapper {
                padding: 40px 0 80px;
            }

            .checkout-page-title {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .checkout-page-subtitle {
                color: var(--text-muted);
                font-size: 0.95rem;
                margin-bottom: 32px;
            }

            .checkout-grid {
                display: grid;
                grid-template-columns: 1.35fr 1fr;
                gap: 30px;
                align-items: start;
            }

            /* ---- Shared card ---- */
            .section-card {
                background: #fff;
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 28px;
                margin-bottom: 24px;
            }

            .section-card:last-child {
                margin-bottom: 0;
            }

            .section-card-title {
                font-size: 1.05rem;
                font-weight: 700;
                margin-bottom: 20px;
                display: flex;
                align-items: center;
                gap: 10px;
                color: var(--text-dark);
            }

            .section-card-title .step-badge {
                width: 28px;
                height: 28px;
                border-radius: 50%;
                background: var(--primary);
                color: #fff;
                font-size: 0.8rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            /* ---- Form elements ---- */
            .form-group {
                margin-bottom: 18px;
            }

            .form-label {
                display: block;
                font-size: 0.875rem;
                font-weight: 600;
                margin-bottom: 6px;
                color: var(--text-dark);
            }

            .form-label .required {
                color: #ef4444;
                margin-left: 2px;
            }

            .form-control {
                width: 100%;
                padding: 10px 14px;
                border: 1.5px solid var(--border-color);
                border-radius: 8px;
                font-size: 0.925rem;
                font-family: 'Inter', sans-serif;
                color: var(--text-dark);
                background: #fff;
                transition: border-color 0.2s, box-shadow 0.2s;
            }

            .form-control:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }

            .form-control.is-invalid {
                border-color: #ef4444;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
            }

            .invalid-feedback {
                margin-top: 5px;
                font-size: 0.8rem;
                color: #ef4444;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .form-hint {
                margin-top: 5px;
                font-size: 0.8rem;
                color: var(--text-muted);
            }

            .char-count {
                font-size: 0.78rem;
                color: var(--text-muted);
                text-align: right;
                margin-top: 4px;
            }

            /* ---- Form row ---- */
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            /* ---- Payment selector ---- */
            .payment-options {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .payment-option {
                border: 2px solid var(--border-color);
                border-radius: 10px;
                padding: 16px;
                cursor: pointer;
                transition: border-color 0.2s, background 0.2s;
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .payment-option.selected {
                border-color: var(--primary);
                background: rgba(37, 99, 235, 0.03);
            }

            .payment-option.disabled {
                opacity: 0.55;
                cursor: not-allowed;
                background: var(--bg-light);
            }

            .payment-option input[type="radio"] {
                accent-color: var(--primary);
                width: 18px;
                height: 18px;
                flex-shrink: 0;
            }

            .payment-option-info {
                flex: 1;
            }

            .payment-option-name {
                font-weight: 600;
                font-size: 0.95rem;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .badge-coming-soon {
                font-size: 0.65rem;
                font-weight: 700;
                background: #f59e0b;
                color: #fff;
                padding: 2px 8px;
                border-radius: 10px;
                letter-spacing: 0.3px;
            }

            .payment-option-desc {
                font-size: 0.8rem;
                color: var(--text-muted);
                margin-top: 3px;
            }

            .payment-option-icon {
                font-size: 1.5rem;
                color: var(--text-muted);
            }

            /* ---- Order Summary (right column) ---- */
            .summary-sticky {
                position: sticky;
                top: 90px;
            }

            .summary-items {
                display: flex;
                flex-direction: column;
                gap: 14px;
                margin-bottom: 20px;
            }

            .summary-item {
                display: flex;
                gap: 12px;
                align-items: flex-start;
            }

            .summary-item-img {
                width: 52px;
                height: 52px;
                border-radius: 6px;
                object-fit: cover;
                background: var(--bg-light);
                flex-shrink: 0;
            }

            .summary-item-details {
                flex: 1;
            }

            .summary-item-name {
                font-size: 0.875rem;
                font-weight: 600;
                margin-bottom: 2px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .summary-item-meta {
                font-size: 0.75rem;
                color: var(--text-muted);
            }

            .summary-item-price {
                font-size: 0.875rem;
                font-weight: 700;
                text-align: right;
                white-space: nowrap;
            }

            .summary-divider {
                border: none;
                border-top: 1px solid var(--border-color);
                margin: 16px 0;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .summary-total {
                display: flex;
                justify-content: space-between;
                font-size: 1.15rem;
                font-weight: 700;
                margin-top: 16px;
                padding-top: 14px;
                border-top: 2px solid var(--border-color);
            }

            /* ---- Submit button ---- */
            .btn-submit-checkout {
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
                margin-top: 20px;
            }

            .btn-submit-checkout:hover:not(:disabled) {
                background: var(--primary-hover);
            }

            .btn-submit-checkout:disabled {
                opacity: 0.65;
                cursor: not-allowed;
            }

            .submit-legal {
                text-align: center;
                font-size: 0.78rem;
                color: var(--text-muted);
                margin-top: 12px;
                line-height: 1.5;
            }

            /* ---- Alert / flash ---- */
            .alert-banner {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 14px 18px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 0.9rem;
            }

            .alert-error {
                background: #fef2f2;
                border: 1px solid #fecaca;
                color: #b91c1c;
            }

            .alert-info {
                background: #eff6ff;
                border: 1px solid #bfdbfe;
                color: #1d4ed8;
            }

            /* ---- Spinner ---- */
            .spinner-icon {
                width: 18px;
                height: 18px;
                border: 2px solid rgba(255, 255, 255, 0.35);
                border-top-color: #fff;
                border-radius: 50%;
                animation: spin 0.7s linear infinite;
                display: inline-block;
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            /* ---- Responsive ---- */
            @media (max-width: 992px) {
                .checkout-grid { grid-template-columns: 1fr; }
                .summary-sticky { position: static; }
            }

            @media (max-width: 576px) {
                .form-row { grid-template-columns: 1fr; }
                .section-card { padding: 20px; }
            }
        </style>
    </x-slot>

    <main class="layout-container checkout-wrapper" x-data="checkoutForm()">

        {{-- Flash error from empty cart guard or generic system error --}}
        @if(session('error'))
            <div class="alert-banner alert-error" role="alert">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Flash error from InsufficientStockException --}}
        @if(session('error_stock'))
            <div class="alert-banner alert-error" role="alert">
                <i class="bi bi-box-seam" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                <div>
                    <strong>Stok tidak mencukupi:</strong><br>
                    {{ session('error_stock') }}<br>
                    <span style="font-size: 0.85rem;">Silakan kurangi kuantitas di keranjang dan coba lagi.</span>
                </div>
            </div>
        @endif

        {{-- Flash info for duplicate / idempotent redirect --}}
        @if(session('info'))
            <div class="alert-banner alert-info" role="alert">
                <i class="bi bi-info-circle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        <h1 class="checkout-page-title">
            <i class="bi bi-clipboard2-check"></i> Checkout
        </h1>
        <p class="checkout-page-subtitle">Lengkapi data pemesan untuk menyelesaikan pesananmu.</p>

        <form id="checkout-form"
              method="POST"
              action="{{ route('checkout.store') }}"
              @submit="handleSubmit">
            @csrf
            <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey }}">

            <div class="checkout-grid">

                {{-- =====================================================
                     LEFT COLUMN: Sections A & C
                ===================================================== --}}
                <div>

                    {{-- Section A: Data Pemesan --}}
                    <div class="section-card">
                        <h2 class="section-card-title">
                            <span class="step-badge">A</span>
                            Data Pemesan
                        </h2>

                        {{-- Validation error summary --}}
                        @if($errors->any())
                            <div class="alert-banner alert-error" role="alert" style="margin-bottom: 20px;">
                                <i class="bi bi-exclamation-circle-fill" style="font-size: 1.1rem; flex-shrink: 0;"></i>
                                <div>
                                    <strong>Terdapat {{ $errors->count() }} kesalahan validasi:</strong>
                                    <ul style="margin: 6px 0 0 16px; padding: 0;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- Nama Lengkap --}}
                        <div class="form-group">
                            <label for="nama_pembeli" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text"
                                   id="nama_pembeli"
                                   name="nama_pembeli"
                                   class="form-control {{ $errors->has('nama_pembeli') ? 'is-invalid' : '' }}"
                                   value="{{ old('nama_pembeli') }}"
                                   placeholder="Sesuai KTM/identitas resmi"
                                   maxlength="255"
                                   required>
                            @error('nama_pembeli')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIM & Fakultas row --}}
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="nim" class="form-label">
                                    NIM <span class="required">*</span>
                                </label>
                                <input type="text"
                                       id="nim"
                                       name="nim"
                                       class="form-control {{ $errors->has('nim') ? 'is-invalid' : '' }}"
                                       value="{{ old('nim') }}"
                                       placeholder="Contoh: 042211333xxx"
                                       maxlength="50"
                                       required>
                                @error('nim')
                                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <label for="fakultas" class="form-label">
                                    Fakultas <span class="required">*</span>
                                </label>
                                <select id="fakultas"
                                        name="fakultas"
                                        class="form-control {{ $errors->has('fakultas') ? 'is-invalid' : '' }}"
                                        required>
                                    <option value="" disabled {{ old('fakultas') ? '' : 'selected' }}>-- Pilih Fakultas --</option>
                                    @foreach($fakultasList as $fak)
                                        <option value="{{ $fak }}" {{ old('fakultas') === $fak ? 'selected' : '' }}>
                                            {{ $fak }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fakultas')
                                    <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div class="form-group" style="margin-top: 18px;">
                            <label for="no_whatsapp" class="form-label">
                                Nomor WhatsApp <span class="required">*</span>
                            </label>
                            <input type="tel"
                                   id="no_whatsapp"
                                   name="no_whatsapp"
                                   class="form-control {{ $errors->has('no_whatsapp') ? 'is-invalid' : '' }}"
                                   value="{{ old('no_whatsapp') }}"
                                   placeholder="Contoh: 08123456789 atau +6281234567890"
                                   maxlength="20"
                                   required>
                            <p class="form-hint"><i class="bi bi-whatsapp" style="color: #25d366;"></i> Nomor ini akan dihubungi panitia untuk konfirmasi pesanan.</p>
                            @error('no_whatsapp')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email (optional) --}}
                        <div class="form-group">
                            <label for="email" class="form-label">Email <span style="color: var(--text-muted); font-weight: 400;">(opsional)</span></label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   value="{{ old('email') }}"
                                   placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Catatan (optional) --}}
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="catatan" class="form-label">Catatan <span style="color: var(--text-muted); font-weight: 400;">(opsional)</span></label>
                            <textarea id="catatan"
                                      name="catatan"
                                      class="form-control {{ $errors->has('catatan') ? 'is-invalid' : '' }}"
                                      placeholder="Misal: ukuran baju, warna preferensi, atau informasi tambahan lainnya..."
                                      rows="3"
                                      maxlength="500"
                                      @input="catatanLength = $event.target.value.length">{{ old('catatan') }}</textarea>
                            <div class="char-count">
                                <span x-text="catatanLength"></span> / 500
                            </div>
                            @error('catatan')
                                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Section C: Metode Pembayaran --}}
                    <div class="section-card">
                        <h2 class="section-card-title">
                            <span class="step-badge">C</span>
                            Metode Pembayaran
                        </h2>

                        <input type="hidden" name="payment_type" :value="selectedPayment">

                        <div class="payment-options">

                            {{-- QRIS Statis (enabled) --}}
                            <div class="payment-option" :class="{ 'selected': selectedPayment === 'qris_statis' }" @click="selectedPayment = 'qris_statis'">
                                <i class="bi bi-qr-code payment-option-icon" style="color: var(--primary);"></i>
                                <div class="payment-option-info">
                                    <div class="payment-option-name">QRIS Statis</div>
                                    <div class="payment-option-desc">Upload bukti transfer setelah pesanan dibuat. Dikonfirmasi oleh panitia dalam 1×24 jam.</div>
                                </div>
                                <input type="radio"
                                       name="_payment_display"
                                       value="qris_statis"
                                       :checked="selectedPayment === 'qris_statis'"
                                       @click.stop="selectedPayment = 'qris_statis'">
                            </div>

                            {{-- QRIS Dinamis (enabled for Stage 9B simulation) --}}
                            <div class="payment-option" :class="{ 'selected': selectedPayment === 'qris_dinamis' }" @click="selectedPayment = 'qris_dinamis'">
                                <i class="bi bi-lightning-charge payment-option-icon" style="color: #f59e0b;"></i>
                                <div class="payment-option-info">
                                    <div class="payment-option-name">
                                        QRIS Dinamis
                                        <span class="badge-coming-soon" style="background: var(--primary);">Simulasi</span>
                                    </div>
                                    <div class="payment-option-desc">Bayar otomatis via Mock Gateway. Stok dikurangi instan setelah pembayaran berhasil.</div>
                                </div>
                                <input type="radio" 
                                       name="_payment_display" 
                                       value="qris_dinamis" 
                                       :checked="selectedPayment === 'qris_dinamis'"
                                       @click.stop="selectedPayment = 'qris_dinamis'">
                            </div>
                        </div>

                        @error('payment_type')
                            <div class="invalid-feedback" style="margin-top: 10px;"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- =====================================================
                     RIGHT COLUMN: Section B — Ringkasan Pesanan
                ===================================================== --}}
                <aside>
                    <div class="summary-sticky">
                        <div class="section-card" style="margin-bottom: 0;">
                            <h2 class="section-card-title">
                                <span class="step-badge">B</span>
                                Ringkasan Pesanan
                            </h2>

                            <div class="summary-items">
                                @foreach($cart['items'] as $key => $item)
                                    <div class="summary-item">
                                        <img class="summary-item-img"
                                             src="{{ $item['gambar'] ? Storage::url($item['gambar']) : 'https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png' }}"
                                             alt="{{ $item['nama'] }}"
                                             onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
                                        <div class="summary-item-details">
                                            <div class="summary-item-name">{{ $item['nama'] }}</div>
                                            <div class="summary-item-meta">
                                                @if($item['tipe'] === 'produk')
                                                    Varian: {{ $item['nama_varian'] }} · Qty: {{ $item['qty'] }}
                                                @else
                                                    Paket Bundling · Qty: {{ $item['qty'] }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="summary-item-price">
                                            Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="summary-divider">

                            <div class="summary-row">
                                <span style="color: var(--text-muted);">Total Item</span>
                                <span style="font-weight: 600;">{{ $cartCount }} Barang</span>
                            </div>

                            <div class="summary-total">
                                <span>Total Tagihan</span>
                                <span>Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                            </div>

                            {{-- Submit Button --}}
                            <button type="submit"
                                    class="btn-submit-checkout"
                                    id="btn-submit-checkout"
                                    :disabled="isSubmitting">
                                <template x-if="!isSubmitting">
                                    <span><i class="bi bi-check2-circle"></i> Buat Pesanan</span>
                                </template>
                                <template x-if="isSubmitting">
                                    <span><span class="spinner-icon"></span> Memproses...</span>
                                </template>
                            </button>

                            <p class="submit-legal">
                                Dengan memesan, kamu menyetujui
                                <a href="#" style="color: var(--primary); text-decoration: none;">syarat &amp; ketentuan</a>
                                OSPEK Amerta 2026.
                            </p>
                        </div>
                    </div>
                </aside>

            </div>
        </form>

    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutForm', () => ({
                selectedPayment: 'qris_statis',
                isSubmitting: false,
                catatanLength: {{ strlen(old('catatan', '')) }},

                handleSubmit(e) {
                    // Prevent double-click / duplicate submission
                    if (this.isSubmitting) {
                        e.preventDefault();
                        return;
                    }

                    if (!this.selectedPayment) {
                        e.preventDefault();
                        alert('Pilih metode pembayaran terlebih dahulu.');
                        return;
                    }

                    this.isSubmitting = true;
                    // Form submits naturally after setting isSubmitting = true
                    // If validation fails and page reloads, isSubmitting resets to false
                },
            }));
        });
    </script>
</x-storefront-layout>
