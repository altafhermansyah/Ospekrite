<x-storefront-layout title="Keranjang Belanja - Ospekrite">
    <x-slot name="styles">
        <style>
            .cart-page-wrapper {
                padding: 40px 0 80px;
            }

            .cart-page-title {
                font-size: 1.75rem;
                font-weight: 700;
                margin-bottom: 30px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .cart-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 30px;
                align-items: start;
            }

            .cart-main-section {
                background: #fff;
                border: 1px solid var(--border-color);
                border-radius: var(--radius);
                padding: 24px;
            }

            .cart-summary-card {
                background: #fff;
                border: 1px solid var(--border-color);
                border-radius: var(--radius);
                padding: 24px;
                position: sticky;
                top: 90px;
            }

            /* Desktop Table Layout */
            .cart-table {
                width: 100%;
                border-collapse: collapse;
            }

            .cart-table th {
                text-align: left;
                padding-bottom: 16px;
                border-bottom: 1px solid var(--border-color);
                color: var(--text-muted);
                font-weight: 600;
                font-size: 0.9rem;
            }

            .cart-table td {
                padding: 20px 0;
                border-bottom: 1px solid var(--border-color);
                vertical-align: middle;
            }

            .cart-table tr:last-child td {
                border-bottom: none;
                padding-bottom: 0;
            }

            .ct-product {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .ct-img {
                width: 80px;
                height: 80px;
                border-radius: 8px;
                object-fit: cover;
                background: var(--bg-light);
            }

            .ct-details {
                flex: 1;
            }

            .ct-name {
                font-weight: 600;
                font-size: 1rem;
                margin-bottom: 4px;
            }

            .ct-variant {
                font-size: 0.85rem;
                color: var(--text-muted);
            }

            .ct-price {
                font-weight: 600;
                color: var(--text-dark);
            }

            .ct-subtotal {
                font-weight: 700;
                font-size: 1.1rem;
            }

            .btn-remove-large {
                background: transparent;
                border: none;
                color: var(--text-muted);
                cursor: pointer;
                font-size: 1.2rem;
                padding: 8px;
                border-radius: 50%;
                transition: background 0.2s, color 0.2s;
            }
            .btn-remove-large:hover {
                background: #fee2e2;
                color: var(--danger);
            }

            /* Quantity Controls (Shared style approach) */
            .qty-group {
                display: inline-flex;
                align-items: center;
                border: 1px solid var(--border-color);
                border-radius: 6px;
                overflow: hidden;
            }

            .qty-btn-mid {
                background: #fff;
                border: none;
                width: 32px;
                height: 32px;
                cursor: pointer;
            }
            .qty-btn-mid:hover:not(:disabled) { background: var(--bg-light); }
            .qty-btn-mid:disabled { color: var(--border-color); cursor: not-allowed; }

            .qty-input-mid {
                width: 40px;
                text-align: center;
                font-weight: 500;
                font-size: 0.95rem;
            }

            /* Summary */
            .summary-title {
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 20px;
                padding-bottom: 16px;
                border-bottom: 1px solid var(--border-color);
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 16px;
                font-size: 0.95rem;
            }

            .summary-total {
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
                padding-top: 16px;
                border-top: 1px solid var(--border-color);
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 24px;
            }

            .btn-checkout-large {
                display: block;
                width: 100%;
                background: var(--primary);
                color: #fff;
                border: none;
                padding: 16px;
                border-radius: var(--radius);
                font-weight: 600;
                font-size: 1.05rem;
                text-align: center;
                text-decoration: none;
                transition: background 0.2s;
            }
            .btn-checkout-large:hover {
                background: var(--primary-hover);
            }

            /* Mobile Overrides */
            .mobile-card-layout { display: none; }
            .desktop-table-layout { display: block; }

            @media (max-width: 992px) {
                .cart-grid { grid-template-columns: 1fr; }
                .cart-summary-card { position: static; }
            }

            @media (max-width: 768px) {
                .desktop-table-layout { display: none; }
                .mobile-card-layout { display: flex; flex-direction: column; gap: 16px; }
                .m-cart-item {
                    border: 1px solid var(--border-color);
                    border-radius: 8px;
                    padding: 16px;
                }
                .m-cart-top {
                    display: flex;
                    gap: 12px;
                    margin-bottom: 16px;
                }
                .m-cart-bottom {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .m-cart-name { font-weight: 600; margin-bottom: 4px; }
                .m-cart-variant { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 8px;}
                .m-cart-price { font-weight: 600; }
                .cart-main-section { padding: 0; border: none; background: transparent; }
            }
        </style>
    </x-slot>

    <main class="layout-container cart-page-wrapper">
        <h1 class="cart-page-title">
            <i class="bi bi-cart3"></i> Keranjang Belanja
        </h1>

        <!-- Empty State -->
        <template x-if="cartItems.length === 0">
            <div style="text-align: center; padding: 60px 0; background: #fff; border: 1px solid var(--border-color); border-radius: var(--radius);">
                <i class="bi bi-cart-x" style="font-size: 5rem; color: var(--border-color); margin-bottom: 24px; display: block;"></i>
                <h2 style="font-weight: 700; margin-bottom: 12px;">Keranjangmu masih kosong</h2>
                <p style="color: var(--text-muted); margin-bottom: 30px;">Yuk mulai lengkapi perlengkapan OSPEK kamu!</p>
                <a href="{{ route('home') }}" class="btn-checkout-large" style="display: inline-block; width: auto; padding: 12px 32px;">Kembali Belanja</a>
            </div>
        </template>

        <!-- Cart Grid -->
        <div class="cart-grid" x-show="cartItems.length > 0" style="display: none;">
            
            <section class="cart-main-section">
                <!-- Desktop Table -->
                <div class="desktop-table-layout">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Kuantitas</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in cartItems" :key="item.key">
                                <tr>
                                    <td>
                                        <div class="ct-product">
                                            <img class="ct-img" :src="item.gambar ? '/storage/' + item.gambar : 'https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'" :alt="item.nama">
                                            <div class="ct-details">
                                                <div class="ct-name" x-text="item.nama"></div>
                                                <div class="ct-variant" x-show="item.tipe === 'produk'" x-text="'Varian: ' + item.nama_varian"></div>
                                                <div class="ct-variant" x-show="item.tipe === 'bundle'">Paket Bundling</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="ct-price" x-text="formatRupiah(item.harga)"></td>
                                    <td>
                                        <div class="qty-group">
                                            <button class="qty-btn-mid" @click="updateQty(item.key, item.qty - 1)" :disabled="item.qty <= 1 || isLoading">-</button>
                                            <div class="qty-input-mid" x-text="item.qty"></div>
                                            <button class="qty-btn-mid" @click="updateQty(item.key, item.qty + 1)" :disabled="item.qty >= 10 || isLoading">+</button>
                                        </div>
                                    </td>
                                    <td class="ct-subtotal" x-text="formatRupiah(item.harga * item.qty)"></td>
                                    <td style="text-align: right;">
                                        <button class="btn-remove-large" @click="removeItem(item.key)" :disabled="isLoading" title="Hapus"><i class="bi bi-trash3"></i></button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="mobile-card-layout">
                    <template x-for="item in cartItems" :key="item.key">
                        <div class="m-cart-item bg-white">
                            <div class="m-cart-top">
                                <img class="ct-img" style="width: 70px; height: 70px;" :src="item.gambar ? '/storage/' + item.gambar : 'https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'" :alt="item.nama">
                                <div class="ct-details">
                                    <div class="m-cart-name" x-text="item.nama"></div>
                                    <div class="m-cart-variant" x-show="item.tipe === 'produk'" x-text="'Varian: ' + item.nama_varian"></div>
                                    <div class="m-cart-variant" x-show="item.tipe === 'bundle'">Paket Bundling</div>
                                    <div class="m-cart-price" x-text="formatRupiah(item.harga)"></div>
                                </div>
                            </div>
                            <div class="m-cart-bottom">
                                <div class="qty-group">
                                    <button class="qty-btn-mid" @click="updateQty(item.key, item.qty - 1)" :disabled="item.qty <= 1 || isLoading">-</button>
                                    <div class="qty-input-mid" x-text="item.qty"></div>
                                    <button class="qty-btn-mid" @click="updateQty(item.key, item.qty + 1)" :disabled="item.qty >= 10 || isLoading">+</button>
                                </div>
                                <button class="btn-remove-large" @click="removeItem(item.key)" :disabled="isLoading"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Order Summary -->
            <aside>
                <div class="cart-summary-card">
                    <h3 class="summary-title">Ringkasan Pesanan</h3>
                    
                    <div class="summary-row">
                        <span style="color: var(--text-muted);">Total Item</span>
                        <span style="font-weight: 600;" x-text="cartCount + ' Barang'"></span>
                    </div>

                    <div class="summary-total">
                        <span>Total Belanja</span>
                        <span x-text="formatRupiah(cartTotal)"></span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout-large">Lanjut ke Checkout</a>
                </div>
            </aside>
        </div>
    </main>

</x-storefront-layout>
