<x-storefront-layout :title="$bundle->nama_bundle . ' - ' . config('ospekrite.nama_site', 'Ospekrite')">
    <x-slot name="styles">
        <style>
            max-width: 1000px;
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

        /* Detail Layout */
        .bundle-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            margin-bottom: 60px;
        }

        .bundle-image-container {
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg-light);
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .bundle-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-type {
            position: absolute;
            top: 16px;
            left: 16px;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            color: #fff;
            background: var(--purple);
        }

        .badge-status {
            position: absolute;
            top: 50px;
            left: 16px;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            color: #fff;
            background: var(--danger);
        }

        .bundle-info {
            display: flex;
            flex-direction: column;
        }

        .bundle-category {
            font-size: 0.85rem;
            color: var(--purple);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .bundle-name {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.2;
        }

        .bundle-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .bundle-desc {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Included Items */
        .section-label {
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .included-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 30px;
        }

        .included-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background: var(--bg-light);
        }

        .included-img {
            width: 48px;
            height: 48px;
            border-radius: 4px;
            object-fit: cover;
            margin-right: 16px;
            background: #fff;
        }

        .included-details {
            flex: 1;
        }

        .included-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .included-qty {
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        .included-status {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--danger);
            margin-left: 10px;
        }

        /* Button */
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
            margin-top: auto;
        }

        .btn-submit:hover:not(:disabled) {
            background: var(--primary-hover);
        }
        
        .btn-submit:disabled {
            background: var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
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
            .bundle-grid { grid-template-columns: 1fr; gap: 24px; }
        }
        @media (max-width: 576px) {
            .bundle-grid { padding: 20px; }
        }
    </style>
    </x-slot>

    <div class="layout-container py-4">
        <a href="{{ route('home') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Katalog
        </a>

        @php
            $isAvailable = true;
            foreach($bundle->bundleItems as $bItem) {
                $stokItem = $bItem->produk->produkVarian->sum('stok');
                if($stokItem == 0) {
                    $isAvailable = false;
                    break;
                }
            }
        @endphp

        <div class="bundle-grid">
            <div class="bundle-image-container">
                <div class="badge-type">Paket Bundling</div>
                @if(!$isAvailable)
                    <div class="badge-status">Tidak Tersedia</div>
                @endif
                <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="{{ $bundle->nama_bundle }}">
            </div>

            <div class="bundle-info">
                <div class="bundle-category">Spesial Amerta 2026</div>
                <h1 class="bundle-name">{{ $bundle->nama_bundle }}</h1>
                <div class="bundle-price">Rp {{ number_format($bundle->harga_bundle, 0, ',', '.') }}</div>
                
                <p class="bundle-desc">{{ $bundle->deskripsi }}</p>

                <div class="section-label">Termasuk dalam paket:</div>
                <div class="included-list">
                    @foreach($bundle->bundleItems as $bItem)
                        @php
                            $itemStock = $bItem->produk->produkVarian->sum('stok');
                        @endphp
                        <div class="included-item">
                            <img class="included-img" src="{{ Storage::url($bItem->produk->gambar_produk) }}" onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
                            <div class="included-details">
                                <div class="included-name">{{ $bItem->produk->nama_produk }}</div>
                                <div class="included-qty">{{ $bItem->qty }} Pcs</div>
                            </div>
                            @if($itemStock == 0)
                                <div class="included-status">Habis</div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <button class="btn-submit" {{ !$isAvailable ? 'disabled' : '' }} onclick="window.dispatchEvent(new CustomEvent('cart-add', {detail: {tipe: 'bundle', id: {{ $bundle->id_bundle }}, qty: 1}}))">
                    <i class="bi bi-cart-plus"></i>
                    <span>{{ !$isAvailable ? 'Bundle Tidak Tersedia' : 'Tambah ke Keranjang' }}</span>
                </button>
            </div>
        </div>
    </div>
</x-storefront-layout>
