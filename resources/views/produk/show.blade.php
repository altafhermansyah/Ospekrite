<x-storefront-layout :title="$produk->nama_produk . ' - ' . config('ospekrite.nama_site', 'Ospekrite')">
    <x-slot name="styles">
        <style>
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navbar Simple */
        header {
            background: #fff;
            padding: 16px 0;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
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

        .btn-back {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            color: var(--primary);
        }

        /* Product Detail Layout */
        .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .product-image-container {
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg-light);
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            color: #fff;
        }
        .badge.out-of-stock { background: var(--danger); }
        .badge.available { background: var(--success); }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-category {
            font-size: 0.85rem;
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .product-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .product-desc {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Variants */
        .section-label {
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .variant-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 30px;
        }

        .variant-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 16px;
            border: 2px solid var(--border-color);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
        }

        .variant-item:hover:not(.disabled) {
            border-color: #cbd5e1;
        }

        .variant-item.selected {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.03);
        }

        .variant-item.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            background: var(--bg-light);
        }

        .variant-name { font-weight: 600; font-size: 1rem; }
        .variant-stock { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }
        .variant-price { font-weight: 600; font-size: 1rem; }
        
        .variant-empty {
            color: var(--danger);
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Qty Selector */
        .qty-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 30px;
        }

        .qty-controls {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            background: #fff;
        }

        .qty-btn {
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--text-dark);
            transition: background 0.2s;
        }
        .qty-btn:hover:not(:disabled) { background: var(--bg-light); }
        .qty-btn:disabled { color: var(--border-color); cursor: not-allowed; }

        .qty-value {
            width: 40px;
            text-align: center;
            font-weight: 600;
            font-size: 1rem;
        }

        .qty-limit {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* Add to cart button */
        .btn-submit {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 16px;
            width: 100%;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover:not(:disabled) {
            background: var(--primary-hover);
        }
        
        .btn-submit:disabled {
            background: var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
        }

        /* Related Products */
        .related-section {
            margin-top: 60px;
            margin-bottom: 60px;
        }

        .related-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .related-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            text-decoration: none;
            color: var(--text-dark);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-sm);
        }

        .related-img {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            background: var(--bg-light);
        }

        .related-body {
            padding: 16px;
        }

        .related-name {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Footer */
        footer {
            background: #fff;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-top: auto;
        }

        @media (max-width: 992px) {
            .product-grid { grid-template-columns: 1fr; gap: 24px; }
            .related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .related-grid { grid-template-columns: 1fr; }
            .product-grid { padding: 20px; }
        }
    </style>
    </x-slot>

    <div class="layout-container py-4" x-data="productDetail({{ $produk->harga_dasar }}, {{ $produk->produkVarian->toJson() }}, {{ config('ospekrite.max_qty_per_item', 10) }})">

    <div>
        <a href="{{ route('home') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Katalog
        </a>

        @php
            $totalStok = $produk->produkVarian->sum('stok');
        @endphp

        <div class="product-grid">
            <div class="product-image-container">
                @if($totalStok == 0)
                    <div class="badge out-of-stock">Habis</div>
                @else
                    <div class="badge available">Tersedia</div>
                @endif
                <img src="{{ Storage::url($produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
            </div>

            <div class="product-info">
                <div class="product-category">{{ $produk->kategori->nama_kategori ?? 'Kategori Umum' }}</div>
                <h1 class="product-name">{{ $produk->nama_produk }}</h1>
                <div class="product-price" x-text="formatRupiah(finalPrice)">Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}</div>
                
                <p class="product-desc">{{ $produk->deskripsi }}</p>

                <div class="section-label">Pilih Varian:</div>
                <div class="variant-list">
                    <template x-for="v in variants" :key="v.id_varian">
                        <div class="variant-item" 
                             :class="{'selected': selectedVariant === v.id_varian, 'disabled': v.stok === 0}"
                             @click="if(v.stok > 0) selectVariant(v)">
                            <div>
                                <div class="variant-name" x-text="v.nama_varian"></div>
                                <template x-if="v.stok > 0">
                                    <div class="variant-stock" x-text="'Stok: ' + v.stok"></div>
                                </template>
                            </div>
                            <div class="text-end">
                                <template x-if="v.stok > 0">
                                    <div class="variant-price">
                                        <template x-if="v.harga_tambahan > 0">
                                            <span x-text="'+ Rp ' + new Intl.NumberFormat('id-ID').format(v.harga_tambahan)"></span>
                                        </template>
                                        <template x-if="v.harga_tambahan == 0">
                                            <span>+ Rp 0</span>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="v.stok === 0">
                                    <div class="variant-empty">Habis</div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="section-label">Kuantitas:</div>
                <div class="qty-wrapper">
                    <div class="qty-controls">
                        <button class="qty-btn" @click="if(qty > 1) qty--" :disabled="!selectedVariant">-</button>
                        <div class="qty-value" x-text="qty"></div>
                        <button class="qty-btn" @click="if(qty < currentMaxQty) qty++" :disabled="!selectedVariant || qty >= currentMaxQty">+</button>
                    </div>
                    <div class="qty-limit" x-show="selectedVariant" x-text="'Maksimal pembelian ' + currentMaxQty + ' pcs'"></div>
                </div>

                <button class="btn-submit" :disabled="!selectedVariant" @click="addToCart()">
                    <i class="bi bi-cart-plus"></i>
                    <span x-text="!selectedVariant ? 'Pilih Varian Dulu' : 'Tambah ke Keranjang'"></span>
                </button>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="related-section">
            <h2 class="related-title">Produk Terkait</h2>
            <div class="related-grid">
                @foreach($relatedProducts as $related)
                    @php
                        $minT = $related->produkVarian->min('harga_tambahan') ?? 0;
                        $rHarga = $related->harga_dasar + $minT;
                    @endphp
                    <a href="{{ route('produk.show', $related->id_produk) }}" class="related-card">
                        <img class="related-img" src="{{ Storage::url($related->gambar_produk) }}" alt="{{ $related->nama_produk }}" onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
                        <div class="related-body">
                            <h3 class="related-name">{{ $related->nama_produk }}</h3>
                            <div class="related-price">Rp {{ number_format($rHarga, 0, ',', '.') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

                addToCart() {
                    window.dispatchEvent(new CustomEvent('cart-add', {
                        detail: { tipe: 'produk', id: this.selectedVariant, qty: this.qty }
                    }));
                }
            }));
        });
    </script>
</x-storefront-layout>
