<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('ospekrite.nama_site', 'Ospekrite') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-400-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-500-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-600-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-700-normal.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-light: #f8f9fa;
            --text-dark: #212529;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --radius: 8px;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.06);
            --danger: #ef4444;
            --success: #10b981;
            --purple: #8b5cf6;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .layout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        /* Navbar Simple */
        header {
            background: #fff;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            text-decoration: none;
            color: var(--primary);
            font-weight: 700;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-icon {
            background: var(--primary);
            color: #fff;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cart-toggle-btn {
            background: transparent;
            border: none;
            font-size: 1.25rem;
            color: var(--text-dark);
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .cart-toggle-btn:hover {
            background: var(--bg-light);
        }

        .badge-counter {
            position: absolute;
            top: 2px;
            right: 0px;
            background: var(--danger);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 12px;
            border: 2px solid #fff;
            transition: transform 0.2s;
        }

        /* Cart Drawer */
        .drawer-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 50;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        
        .drawer-backdrop.show {
            opacity: 1;
            pointer-events: auto;
        }

        .cart-drawer {
            position: fixed;
            top: 0;
            right: -420px;
            width: 100%;
            max-width: 420px;
            height: 100vh;
            background: #fff;
            z-index: 60;
            box-shadow: -4px 0 15px rgba(0,0,0,0.05);
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-drawer.show {
            right: 0;
        }

        .drawer-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .drawer-title {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .btn-close-drawer {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-muted);
            line-height: 1;
        }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .drawer-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-muted);
            text-align: center;
        }

        .drawer-empty i {
            font-size: 4rem;
            color: var(--border-color);
            margin-bottom: 16px;
        }

        .drawer-item {
            display: flex;
            gap: 12px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .drawer-item-img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--bg-light);
        }

        .drawer-item-details {
            flex: 1;
        }

        .drawer-item-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .drawer-item-variant {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .drawer-item-actions {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .qty-controls-small {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .qty-btn-small {
            background: #fff;
            border: none;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .qty-btn-small:hover:not(:disabled) { background: var(--bg-light); }
        .qty-btn-small:disabled { color: var(--border-color); cursor: not-allowed; }

        .qty-input-small {
            width: 30px;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .drawer-item-price {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .btn-remove-item {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
        }
        .btn-remove-item:hover {
            color: var(--danger);
        }

        .drawer-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            background: var(--bg-light);
        }

        .drawer-subtotal {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .btn-primary-full {
            display: block;
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-primary-full:hover {
            background: var(--primary-hover);
        }

        footer {
            background: #fff;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: auto;
        }

        /* Badge Animation */
        @keyframes bump {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        .bump-anim {
            animation: bump 0.3s ease-out;
        }
    </style>
    {{ $styles ?? '' }}
</head>
<body x-data="cartStore()">

    <header>
        <div class="layout-container header-content">
            <a href="{{ route('home') }}" class="brand-link">
                <span class="brand-icon"><i class="bi bi-box-seam"></i></span>
                {{ config('ospekrite.nama_site', 'Ospekrite') }}
            </a>
            
            <div class="nav-actions">
                {{ $navExtra ?? '' }}
                <button class="cart-toggle-btn" @click="isDrawerOpen = true">
                    <i class="bi bi-cart3"></i>
                    <span class="badge-counter" x-show="cartCount > 0" x-text="cartCount" :class="{'bump-anim': isAnimating}"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    {{ $slot }}

    <!-- Footer -->
    <footer>
        <div class="layout-container">
            © {{ config('ospekrite.tahun', date('Y')) }} {{ config('ospekrite.nama_site', 'Ospekrite') }}. All rights reserved.
        </div>
    </footer>

    <!-- Cart Drawer -->
    <div class="drawer-backdrop" :class="{'show': isDrawerOpen}" @click="isDrawerOpen = false"></div>
    <div class="cart-drawer" :class="{'show': isDrawerOpen}">
        <div class="drawer-header">
            <span class="drawer-title">Keranjang Belanja</span>
            <button class="btn-close-drawer" @click="isDrawerOpen = false"><i class="bi bi-x"></i></button>
        </div>
        
        <div class="drawer-body">
            <template x-if="cartItems.length === 0">
                <div class="drawer-empty">
                    <i class="bi bi-cart-x"></i>
                    <h4 style="margin-bottom: 8px; color: var(--text-dark);">Keranjangmu masih kosong</h4>
                    <p style="font-size: 0.9rem; margin-bottom: 20px;">Ayo mulai belanja perlengkapan OSPEK-mu sekarang!</p>
                    <a href="{{ route('home') }}" class="btn-primary-full" style="width: auto; padding: 10px 24px;" @click="isDrawerOpen = false">Lihat Katalog</a>
                </div>
            </template>

            <template x-if="cartItems.length > 0">
                <div>
                    <template x-for="item in cartItems" :key="item.key">
                        <div class="drawer-item">
                            <img class="drawer-item-img" :src="item.gambar ? '/storage/' + item.gambar : 'https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'" :alt="item.nama">
                            <div class="drawer-item-details">
                                <div class="drawer-item-name" x-text="item.nama"></div>
                                <div class="drawer-item-variant" x-show="item.tipe === 'produk'" x-text="'Varian: ' + item.nama_varian"></div>
                                <div class="drawer-item-variant" x-show="item.tipe === 'bundle'">Paket Bundling</div>
                                
                                <div class="drawer-item-actions mt-2">
                                    <div class="qty-controls-small">
                                        <button class="qty-btn-small" @click="updateQty(item.key, item.qty - 1)" :disabled="item.qty <= 1 || isLoading">-</button>
                                        <div class="qty-input-small" x-text="item.qty"></div>
                                        <button class="qty-btn-small" @click="updateQty(item.key, item.qty + 1)" :disabled="item.qty >= 10 || isLoading">+</button>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="drawer-item-price" x-text="formatRupiah(item.harga * item.qty)"></div>
                                        <button class="btn-remove-item mt-1" @click="removeItem(item.key)" :disabled="isLoading"><i class="bi bi-trash3"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <template x-if="cartItems.length > 0">
            <div class="drawer-footer">
                <div class="drawer-subtotal">
                    <span>Grand Total</span>
                    <span x-text="formatRupiah(cartTotal)"></span>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn-primary-full" style="margin-bottom: 10px;">Lanjut ke Checkout</a>
                <a href="{{ route('cart.index') }}" class="btn-primary-full" style="background: transparent; color: var(--primary); border: 1px solid var(--primary);">Lihat Keranjang</a>
            </div>
        </template>
    </div>

    <!-- Global Cart Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cartStore', () => ({
                isDrawerOpen: false,
                cartCount: 0,
                cartTotal: 0,
                cartItemsRaw: {},
                isAnimating: false,
                isLoading: false,

                get cartItems() {
                    return Object.keys(this.cartItemsRaw).map(key => {
                        return { key: key, ...this.cartItemsRaw[key] };
                    });
                },

                init() {
                    this.fetchCart();
                },

                formatRupiah(amount) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
                },

                async fetchCart() {
                    try {
                        let res = await fetch('{{ route('cart.data') }}');
                        let data = await res.json();
                        if (data.success) {
                            this.updateState(data);
                        }
                    } catch (e) {
                        console.error('Failed to load cart', e);
                    }
                },

                async addItem(tipe, idRef, qty) {
                    this.isLoading = true;
                    try {
                        let res = await fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ tipe, id_ref: idRef, qty })
                        });
                        let data = await res.json();
                        if (data.success) {
                            await this.fetchCart();
                            this.isDrawerOpen = true;
                            this.triggerAnimation();
                        } else {
                            alert(data.message || 'Gagal menambahkan ke keranjang');
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        this.isLoading = false;
                    }
                },

                async updateQty(key, newQty) {
                    if (newQty < 1 || newQty > 10) return;
                    this.isLoading = true;
                    try {
                        let res = await fetch('{{ route('cart.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ key, qty: newQty })
                        });
                        let data = await res.json();
                        if (data.success) {
                            await this.fetchCart();
                            this.triggerAnimation();
                        } else {
                            alert(data.message || 'Gagal mengubah kuantitas');
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        this.isLoading = false;
                    }
                },

                async removeItem(key) {
                    if (!confirm('Hapus item dari keranjang?')) return;
                    this.isLoading = true;
                    try {
                        let res = await fetch('{{ route('cart.remove') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ key })
                        });
                        let data = await res.json();
                        if (data.success) {
                            await this.fetchCart();
                            this.triggerAnimation();
                        }
                    } catch (e) {
                        alert('Terjadi kesalahan jaringan.');
                    } finally {
                        this.isLoading = false;
                    }
                },

                updateState(data) {
                    this.cartCount = data.cart_count;
                    this.cartTotal = data.cart_total;
                    this.cartItemsRaw = data.cart.items || {};
                },

                triggerAnimation() {
                    this.isAnimating = false;
                    setTimeout(() => { this.isAnimating = true; }, 50);
                }
            }));
        });
    </script>
</body>
</html>
