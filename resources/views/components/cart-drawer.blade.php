<!-- Global Cart State and Drawer Component -->
<style>
    /* Drawer Scoped CSS */
    .drawer-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1040; /* Above Bootstrap nav */
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }
    
    .drawer-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }

    .cart-drawer-wrapper {
        position: fixed;
        top: 0;
        right: -420px;
        width: 100%;
        max-width: 420px;
        height: 100vh;
        background: #fff;
        z-index: 1050;
        box-shadow: -4px 0 15px rgba(0,0,0,0.05);
        transition: right 0.3s ease;
        display: flex;
        flex-direction: column;
        color: #212529;
        font-family: 'Inter', sans-serif;
    }

    .cart-drawer-wrapper.show {
        right: 0;
    }

    .cd-header {
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cd-title {
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .cd-close {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
        line-height: 1;
        padding: 0;
    }

    .cd-body {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .cd-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #6c757d;
        text-align: center;
    }

    .cd-empty i {
        font-size: 4rem;
        color: #e9ecef;
        margin-bottom: 16px;
    }

    .cd-item {
        display: flex;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e9ecef;
    }

    .cd-item-img {
        width: 70px;
        height: 70px;
        border-radius: 6px;
        object-fit: cover;
        background: #f8f9fa;
    }

    .cd-item-details {
        flex: 1;
    }

    .cd-item-name {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .cd-item-variant {
        font-size: 0.75rem;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .cd-item-actions {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .cd-qty {
        display: flex;
        align-items: center;
        border: 1px solid #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }

    .cd-qty-btn {
        background: #fff;
        border: none;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
    }
    .cd-qty-btn:hover:not(:disabled) { background: #f8f9fa; }
    .cd-qty-btn:disabled { color: #e9ecef; cursor: not-allowed; }

    .cd-qty-input {
        width: 30px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .cd-item-price {
        font-weight: 700;
        font-size: 0.95rem;
    }

    .cd-remove {
        background: transparent;
        border: none;
        color: #6c757d;
        cursor: pointer;
        padding: 4px 0 0;
        font-size: 0.85rem;
    }
    .cd-remove:hover {
        color: #ef4444;
    }

    .cd-footer {
        padding: 20px;
        border-top: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .cd-subtotal {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .cd-btn-primary {
        display: block;
        width: 100%;
        background: #2563eb;
        color: #fff;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        text-align: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .cd-btn-primary:hover {
        background: #1d4ed8;
        color: #fff;
    }

    @keyframes badge-bump {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }
    .anim-bump {
        animation: badge-bump 0.3s ease-out;
    }
</style>

<div x-data="cartStore()" @cart-add.window="addItem($event.detail.tipe, $event.detail.id, $event.detail.qty)">
    <!-- Drawer Backdrop -->
    <div class="drawer-backdrop" :class="{'show': isDrawerOpen}" @click="isDrawerOpen = false"></div>
    
    <!-- Drawer -->
    <div class="cart-drawer-wrapper" :class="{'show': isDrawerOpen}">
        <div class="cd-header">
            <h5 class="cd-title">Keranjang Belanja</h5>
            <button class="cd-close" @click="isDrawerOpen = false"><i class="bi bi-x"></i></button>
        </div>
        
        <div class="cd-body">
            <template x-if="cartItems.length === 0">
                <div class="cd-empty">
                    <i class="bi bi-cart-x"></i>
                    <h5 style="margin-bottom: 8px; font-weight: 700;">Keranjangmu masih kosong</h5>
                    <p style="font-size: 0.9rem; margin-bottom: 20px;">Ayo mulai belanja perlengkapan OSPEK-mu sekarang!</p>
                    <a href="{{ route('home') }}" class="cd-btn-primary" style="width: auto; padding: 10px 24px;" @click="isDrawerOpen = false">Lihat Katalog</a>
                </div>
            </template>

            <template x-if="cartItems.length > 0">
                <div>
                    <template x-for="item in cartItems" :key="item.key">
                        <div class="cd-item">
                            <img class="cd-item-img" :src="item.gambar ? '/storage/' + item.gambar : 'https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'" :alt="item.nama">
                            <div class="cd-item-details">
                                <div class="cd-item-name" x-text="item.nama"></div>
                                <div class="cd-item-variant" x-show="item.tipe === 'produk'" x-text="'Varian: ' + item.nama_varian"></div>
                                <div class="cd-item-variant" x-show="item.tipe === 'bundle'">Paket Bundling</div>
                                
                                <div class="cd-item-actions mt-2">
                                    <div class="cd-qty">
                                        <button class="cd-qty-btn" @click="updateQty(item.key, item.qty - 1)" :disabled="item.qty <= 1 || isLoading">-</button>
                                        <div class="cd-qty-input" x-text="item.qty"></div>
                                        <button class="cd-qty-btn" @click="updateQty(item.key, item.qty + 1)" :disabled="item.qty >= 10 || isLoading">+</button>
                                    </div>
                                    <div style="text-align: right;">
                                        <div class="cd-item-price" x-text="formatRupiah(item.harga * item.qty)"></div>
                                        <button class="cd-remove" @click="removeItem(item.key)" :disabled="isLoading"><i class="bi bi-trash3"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <template x-if="cartItems.length > 0">
            <div class="cd-footer">
                <div class="cd-subtotal">
                    <span>Grand Total</span>
                    <span x-text="formatRupiah(cartTotal)"></span>
                </div>
                <a href="{{ route('cart.index') }}" class="cd-btn-primary">Lihat Keranjang</a>
            </div>
        </template>
    </div>

    <!-- Hidden element to expose properties to the global scope for the Badge and Triggers -->
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
                    // Attach to window so badges outside this component can read it
                    window.openCartDrawer = () => { this.isDrawerOpen = true; };
                    this.$watch('cartCount', value => {
                        window.dispatchEvent(new CustomEvent('cart-count-updated', { detail: value }));
                    });
                    
                    // Listen for global toggle
                    window.addEventListener('toggle-cart', () => {
                        this.isDrawerOpen = true;
                    });
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
                        let csrf = document.querySelector('meta[name="csrf-token"]');
                        if(!csrf) {
                            alert("CSRF token missing! Tambahkan <meta name='csrf-token' content='{{ csrf_token() }}'> ke head.");
                            return;
                        }

                        let res = await fetch('{{ route('cart.add') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf.getAttribute('content')
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
                    window.dispatchEvent(new CustomEvent('cart-anim'));
                }
            }));
        });
    </script>
</div>
