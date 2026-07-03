<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('ospekrite.nama_site', 'Ospekrite') }} - Perlengkapan {{ config('ospekrite.nama_event', 'OSPEK') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar */
        .navbar-custom {
            background: #fff;
            box-shadow: var(--shadow-sm);
            padding: 12px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand .brand-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: #fff;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .nav-link-custom {
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 12px !important;
            border-radius: 6px;
            transition: background 0.15s;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            background: var(--bg-light);
        }

        .search-bar {
            flex: 1;
            max-width: 560px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 0.9rem;
            background: var(--bg-light);
            transition: all 0.2s;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-bar .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .nav-icon-btn {
            position: relative;
            background: transparent;
            border: none;
            color: var(--text-dark);
            font-size: 1.25rem;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.15s;
        }

        .nav-icon-btn:hover {
            background: var(--bg-light);
        }

        .badge-counter {
            position: absolute;
            top: 2px;
            right: 2px;
            background: #ef4444;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 600;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid #fff;
        }

        /* Hero */
        .hero-section {
            background: #fff;
            border-bottom: 1px solid var(--border-color);
        }

        .hero-content {
            padding: 64px 0;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(37, 99, 235, 0.08);
            color: var(--primary);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.15;
            color: var(--text-dark);
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 12px 28px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-custom:hover {
            background: var(--primary);
            color: #fff;
        }

        .hero-image-wrap {
            background: var(--bg-light);
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 4/3;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Section */
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        /* Product Card */
        .product-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
            height: 100%;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .product-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
            color: inherit;
        }

        .product-image-wrap {
            position: relative;
            aspect-ratio: 1/1;
            overflow: hidden;
            background: var(--bg-light);
        }

        .product-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image-wrap img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--primary);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
            z-index: 2;
        }

        .product-badge.out-of-stock {
            background: #ef4444;
        }

        .product-badge.bundle-badge {
            background: #8b5cf6;
        }

        .product-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-title {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            line-height: 1.4;
            margin-bottom: 6px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.5em;
        }

        .product-faculty {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .btn-add-cart {
            width: 100%;
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            margin-top: auto;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: var(--primary);
            color: #fff;
        }

        .btn-add-cart:disabled {
            border-color: var(--border-color);
            color: var(--text-muted);
            cursor: not-allowed;
            background: var(--bg-light);
        }

        /* Pill Tabs */
        .pill-tabs {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 10px;
            margin-bottom: 20px;
            scrollbar-width: none;
        }
        .pill-tabs::-webkit-scrollbar {
            display: none;
        }
        .pill-tab {
            white-space: nowrap;
            padding: 8px 16px;
            border-radius: 20px;
            background: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
        }
        .pill-tab:hover {
            border-color: var(--primary);
        }
        .pill-tab.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* Variant Modal */
        .modal-variant-item {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .modal-variant-item.selected {
            border-color: var(--primary);
            background-color: rgba(37, 99, 235, 0.05);
        }
        .modal-variant-item.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: var(--bg-light);
        }

        /* Offcanvas Cart */
        .offcanvas-cart {
            width: 420px !important;
            border-left: 1px solid var(--border-color);
        }

        .offcanvas-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .offcanvas-title {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .cart-items {
            padding: 16px 24px;
            overflow-y: auto;
            flex: 1;
        }

        .cart-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--text-muted);
            text-align: center;
        }

        .cart-empty i {
            font-size: 4rem;
            margin-bottom: 16px;
            color: var(--border-color);
        }

        @media (max-width: 991.98px) {
            .search-bar {
                max-width: 100%;
                margin: 12px 0;
            }
            .hero-title {
                font-size: 2rem;
            }
            .hero-content {
                padding: 40px 0;
            }
        }
        @media (max-width: 575.98px) {
            .hero-title {
                font-size: 1.6rem;
            }
            .offcanvas-cart {
                width: 100% !important;
            }
        }
    </style>
    <style>
        /* Badge Animation for Nav */
        @keyframes badge-bump {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
        .anim-bump {
            animation: badge-bump 0.3s ease-out;
        }
    </style>
</head>
<body x-data="storefront()">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-icon"><i class="bi bi-box-seam"></i></span>
                {{ config('ospekrite.nama_site', 'Ospekrite') }}
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Kategori
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm" style="border-radius: 8px;">
                            <li><a class="dropdown-item py-2 {{ empty($kategoriId) ? 'active' : '' }}" href="{{ route('home') }}">Semua Kategori</a></li>
                            @foreach($kategoriList as $kat)
                                <li><a class="dropdown-item py-2 {{ $kategoriId == $kat->id_kategori ? 'active' : '' }}" href="{{ route('home', ['kategori' => $kat->id_kategori]) }}">{{ $kat->nama_kategori }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>

                <div class="search-bar mx-auto">
                    <form action="{{ route('home') }}" method="GET">
                        @if($kategoriId)
                            <input type="hidden" name="kategori" value="{{ $kategoriId }}">
                        @endif
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari perlengkapan OSPEK...">
                    </form>
                </div>

                <div class="d-flex align-items-center gap-1 ms-lg-3 mt-3 mt-lg-0">
                    <a href="{{ route('track.index') }}" class="nav-icon-btn text-decoration-none" title="Cek Status Pesananku">
                        <i class="bi bi-truck"></i>
                    </a>
                    <button class="nav-icon-btn" title="Keranjang" onclick="window.dispatchEvent(new Event('toggle-cart'))" x-data="{ count: 0, anim: false }" @cart-count-updated.window="count = $event.detail" @cart-anim.window="anim = false; setTimeout(() => anim = true, 50)">
                        <i class="bi bi-bag"></i>
                        <span class="badge-counter" x-show="count > 0" x-text="count" :class="{'anim-bump': anim}">0</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-6">
                    <span class="hero-badge"><i class="bi bi-stars me-1"></i> {{ config('ospekrite.nama_event', 'OSPEK Amerta 2026') }} · Resmi</span>
                    <h1 class="hero-title">Perlengkapan OSPEK 2026 Ready!</h1>
                    <p class="hero-subtitle">Dapatkan paket lengkap sesuai fakultasmu tanpa ribet. Kualitas terjamin, pengambilan mudah di area kampus saat penukaran.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#katalog" class="btn-primary-custom">Lihat Katalog</a>
                        <a href="{{ route('track.index') }}" class="btn-outline-custom">Cek Status Pesananku</a>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="hero-image-wrap">
                        <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/1e6001c79-70fb-42e5-8e93-22f4eb6dee3e.png" alt="OSPEK Kit Bundle">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newest Products Grid -->
    @if($newestProduk->count() > 0 && empty($query) && empty($kategoriId))
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Produk Terbaru</h2>
            <p class="section-subtitle">Perlengkapan OSPEK yang baru saja ditambahkan</p>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($newestProduk as $item)
                    @php
                        $minTambahan = $item->produkVarian->min('harga_tambahan') ?? 0;
                        $hargaAwal = $item->harga_dasar + $minTambahan;
                        $totalStok = $item->produkVarian->sum('stok');
                    @endphp
                    <div class="col">
                        <div class="product-card" @click="openModal('produk', {{ $item->id_produk }}, {{ json_encode($item) }})">
                            <div class="product-image-wrap">
                                @if($totalStok == 0)
                                    <span class="product-badge out-of-stock">Habis</span>
                                @else
                                    <span class="product-badge">Baru</span>
                                @endif
                                <img src="{{ Storage::url($item->gambar_produk) }}" alt="{{ $item->nama_produk }}" onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">{{ $item->nama_produk }}</h3>
                                <div class="product-faculty">{{ $item->kategori->nama_kategori ?? 'Kategori Umum' }}</div>
                                <div class="product-price">
                                    Mulai dari Rp {{ number_format($hargaAwal, 0, ',', '.') }}
                                </div>
                                <button class="btn-add-cart" {{ $totalStok == 0 ? 'disabled' : '' }}>
                                    {{ $totalStok == 0 ? 'Stok Habis' : '+ Keranjang' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Bundle Grid -->
    @if($bundles->count() > 0 && empty($query) && empty($kategoriId))
    <section class="py-5 border-top">
        <div class="container">
            <h2 class="section-title">Paket Bundling</h2>
            <p class="section-subtitle">Beli paket lebih hemat dan praktis</p>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($bundles as $bundle)
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
                    <div class="col">
                        <div class="product-card">
                            <div class="product-image-wrap">
                                <span class="product-badge bundle-badge">Bundle</span>
                                @if(!$isAvailable)
                                    <span class="product-badge out-of-stock" style="top: 36px;">Tidak Tersedia</span>
                                @endif
                                <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="{{ $bundle->nama_bundle }}">
                            </div>
                            <div class="product-body">
                                <h3 class="product-title">{{ $bundle->nama_bundle }}</h3>
                                <div class="product-faculty">Paket Komplit</div>
                                <div class="product-price">
                                    Rp {{ number_format($bundle->harga_bundle, 0, ',', '.') }}
                                </div>
                                <button class="btn-add-cart" {{ !$isAvailable ? 'disabled' : '' }} @click.stop="window.dispatchEvent(new CustomEvent('cart-add', {detail: {tipe: 'bundle', id: {{ $bundle->id_bundle }}, qty: 1}}))">
                                    {{ !$isAvailable ? 'Item Bundle Habis' : '+ Keranjang' }}
                                </button>
                                <div class="mt-2 text-center"><a href="{{ route('bundle.show', $bundle->id_bundle) }}" class="text-decoration-none text-muted" style="font-size: 0.8rem;">Lihat Detail</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Product Grid -->
    <section class="py-5 border-top" id="katalog">
        <div class="container">
            <h2 class="section-title">Katalog Produk</h2>
            <p class="section-subtitle">Cari dan pilih perlengkapan sesuai kebutuhanmu</p>

            <!-- Filters -->
            <div class="pill-tabs">
                <a href="{{ route('home') }}#katalog" class="pill-tab {{ empty($kategoriId) ? 'active' : '' }}">Semua</a>
                @foreach($kategoriList as $kat)
                    <a href="{{ route('home', ['kategori' => $kat->id_kategori]) }}#katalog" class="pill-tab {{ $kategoriId == $kat->id_kategori ? 'active' : '' }}">{{ $kat->nama_kategori }}</a>
                @endforeach
            </div>

            @if($produk->count() > 0)
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
                    @foreach($produk as $item)
                        @php
                            $minTambahan = $item->produkVarian->min('harga_tambahan') ?? 0;
                            $hargaAwal = $item->harga_dasar + $minTambahan;
                            $totalStok = $item->produkVarian->sum('stok');
                        @endphp
                        <div class="col">
                            <div class="product-card" @click="openModal('produk', {{ $item->id_produk }}, {{ json_encode($item) }})">
                                <div class="product-image-wrap">
                                    @if($totalStok == 0)
                                        <span class="product-badge out-of-stock">Habis</span>
                                    @endif
                                    <img src="{{ Storage::url($item->gambar_produk) }}" alt="{{ $item->nama_produk }}" onerror="this.src='https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png'">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-title">{{ $item->nama_produk }}</h3>
                                    <div class="product-faculty">{{ $item->kategori->nama_kategori ?? 'Kategori Umum' }}</div>
                                    <div class="product-price">
                                        Mulai dari Rp {{ number_format($hargaAwal, 0, ',', '.') }}
                                    </div>
                                    <button class="btn-add-cart" {{ $totalStok == 0 ? 'disabled' : '' }}>
                                        {{ $totalStok == 0 ? 'Stok Habis' : '+ Keranjang' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center">
                    {{ $produk->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 mb-3 d-block text-secondary"></i>
                    <h5>Produk tidak ditemukan</h5>
                    <p>Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-4">
        <div class="container text-center text-muted" style="font-size: 0.85rem;">
            © {{ config('ospekrite.tahun', date('Y')) }} {{ config('ospekrite.nama_site', 'Ospekrite') }}. All rights reserved.
        </div>
    </footer>

    <!-- Variant Picker Modal -->
    <div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" x-text="modalProduct ? modalProduct.nama_produk : ''"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3" x-text="modalProduct ? modalProduct.deskripsi : ''"></p>
                    <div class="fw-semibold mb-2">Pilih Varian:</div>
                    
                    <template x-if="modalProduct && modalProduct.produk_varian">
                        <div>
                            <template x-for="varian in modalProduct.produk_varian" :key="varian.id_varian">
                                <div class="modal-variant-item" 
                                     :class="{ 'selected': selectedVariantId === varian.id_varian, 'disabled': varian.stok === 0 }"
                                     @click="if(varian.stok > 0) selectVariant(varian.id_varian, modalProduct.harga_dasar + varian.harga_tambahan, varian.stok)">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-medium" x-text="varian.nama_varian"></div>
                                            <div class="small text-muted" x-text="'Stok: ' + varian.stok"></div>
                                        </div>
                                        <div class="fw-bold" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(modalProduct.harga_dasar + varian.harga_tambahan)"></div>
                                    </div>
                                    <template x-if="varian.stok === 0">
                                        <div class="text-danger small fw-semibold mt-1">Habis</div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                    
                    <div class="mt-3">
                        <div class="fw-semibold mb-2">Kuantitas:</div>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-secondary px-3" @click="qty > 1 ? qty-- : null" :disabled="!selectedVariantId">-</button>
                            <span class="fw-bold fs-5" x-text="qty"></span>
                            <button class="btn btn-outline-secondary px-3" @click="qty < maxQty ? qty++ : null" :disabled="!selectedVariantId || qty >= maxQty">+</button>
                            <span class="text-muted small ms-2" x-show="selectedVariantId" x-text="'Maks. ' + maxQty"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <div class="w-100 d-flex justify-content-between align-items-center mb-2" x-show="selectedVariantId">
                        <span class="text-muted">Total:</span>
                        <span class="fw-bold fs-5" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedPrice * qty)"></span>
                    </div>
                    <button type="button" class="btn btn-primary w-100" :disabled="!selectedVariantId" @click="window.dispatchEvent(new CustomEvent('cart-add', {detail: {tipe: 'produk', id: selectedVariantId, qty: qty}})); modalInstance.hide();">
                        <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                    </button>
                    <div class="w-100 text-center mt-2">
                        <a :href="'/produk/' + (modalProduct ? modalProduct.id_produk : '')" class="text-decoration-none text-muted small">Lihat Detail Produk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-cart-drawer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('storefront', () => ({
                cartCount: 0,
                modalProduct: null,
                selectedVariantId: null,
                selectedPrice: 0,
                maxQty: 10,
                qty: 1,
                modalInstance: null,

                init() {
                    this.modalInstance = new bootstrap.Modal(document.getElementById('variantModal'));
                },

                openModal(type, id, data) {
                    if (type === 'produk') {
                        this.modalProduct = data;
                        this.selectedVariantId = null;
                        this.selectedPrice = 0;
                        this.qty = 1;
                        this.maxQty = 10;
                        this.modalInstance.show();
                    }
                },

                selectVariant(variantId, price, stock) {
                    this.selectedVariantId = variantId;
                    this.selectedPrice = price;
                    this.maxQty = Math.min(stock, {{ config('ospekrite.max_qty_per_item', 10) }});
                    this.qty = 1;
                }
            }));
        });
    </script>
</body>
</html>
