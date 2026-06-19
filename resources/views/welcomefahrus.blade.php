<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSPEK Kit Store - Perlengkapan OSPEK 2026</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-400-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-500-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-600-normal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontsource/css/inter@4.5/latin-700-normal.css">
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

        .nav-link-custom:hover {
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

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
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

        /* Countdown */
        .countdown-banner {
            background: #fff;
            border-top: 1px solid var(--border-color);
            padding: 16px 0;
        }

        .countdown-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .countdown-label .flash-icon {
            color: #f59e0b;
        }

        .countdown-timer {
            display: flex;
            gap: 8px;
        }

        .countdown-box {
            background: var(--text-dark);
            color: #fff;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.95rem;
            min-width: 48px;
            text-align: center;
            font-variant-numeric: tabular-nums;
        }

        .countdown-box .unit {
            font-size: 0.65rem;
            font-weight: 500;
            color: #adb5bd;
            display: block;
            margin-top: 2px;
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
        }

        .product-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
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

        .product-badge.discount {
            background: #ef4444;
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

        .product-rating {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .product-rating .star {
            color: #f59e0b;
        }

        .product-price {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .product-price .original {
            font-size: 0.8rem;
            font-weight: 400;
            color: var(--text-muted);
            text-decoration: line-through;
            margin-left: 6px;
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

        .btn-add-cart:hover {
            background: var(--primary);
            color: #fff;
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

        .cart-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-img {
            width: 72px;
            height: 72px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--bg-light);
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
            min-width: 0;
        }

        .cart-item-title {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-variant {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .qty-control {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-btn {
            background: #fff;
            border: none;
            width: 28px;
            height: 28px;
            font-size: 0.9rem;
            color: var(--text-dark);
            cursor: pointer;
            transition: background 0.15s;
        }

        .qty-btn:hover {
            background: var(--bg-light);
        }

        .qty-input {
            width: 36px;
            height: 28px;
            border: none;
            border-left: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
            text-align: center;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .qty-input:focus {
            outline: none;
        }

        .cart-item-remove {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 1rem;
            padding: 4px;
            cursor: pointer;
            transition: color 0.15s;
            align-self: flex-start;
        }

        .cart-item-remove:hover {
            color: #ef4444;
        }

        .cart-item-price {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-top: 6px;
        }

        .cart-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
            background: #fff;
        }

        .cart-subtotal {
            display: flex;
            justify-content: space-between;
            margin-bottom: 14px;
            font-size: 0.9rem;
        }

        .cart-subtotal .label {
            color: var(--text-muted);
        }

        .cart-subtotal .value {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .btn-checkout {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .btn-checkout:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        /* Checkout */
        .checkout-section {
            padding: 48px 0 64px;
        }

        .checkout-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 20px;
        }

        .checkout-card-title {
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkout-card-title .step {
            width: 26px;
            height: 26px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .address-card {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 16px;
            display: flex;
            gap: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .address-card:hover, .address-card.active {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.02);
        }

        .address-card .radio {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 2px;
            position: relative;
        }

        .address-card.active .radio {
            border-color: var(--primary);
        }

        .address-card.active .radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
        }

        .address-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .address-detail {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .address-phone {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .link-primary {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
        }

        .link-primary:hover {
            text-decoration: underline;
        }

        .checkout-item {
            display: flex;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .checkout-item:last-child {
            border-bottom: none;
        }

        .checkout-item-img {
            width: 64px;
            height: 64px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--bg-light);
        }

        .checkout-item-title {
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .checkout-item-variant {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .checkout-item-price {
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: auto;
            white-space: nowrap;
        }

        .courier-option {
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 16px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 10px;
        }

        .courier-option:hover, .courier-option.active {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.02);
        }

        .courier-option .radio {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            flex-shrink: 0;
            position: relative;
        }

        .courier-option.active .radio {
            border-color: var(--primary);
        }

        .courier-option.active .radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
        }

        .courier-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .courier-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .courier-price {
            font-weight: 600;
            font-size: 0.9rem;
            margin-left: auto;
            white-space: nowrap;
        }

        .order-summary {
            position: sticky;
            top: 90px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 0.9rem;
        }

        .summary-row .label {
            color: var(--text-muted);
        }

        .summary-row.discount .value {
            color: #ef4444;
        }

        .summary-divider {
            border-top: 1px dashed var(--border-color);
            margin: 8px 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            padding: 14px 0 4px;
            font-size: 1rem;
        }

        .summary-total .label {
            font-weight: 600;
        }

        .summary-total .value {
            font-weight: 700;
            font-size: 1.15rem;
        }

        .btn-payment {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: var(--radius);
            font-weight: 600;
            font-size: 0.95rem;
            margin-top: 16px;
            transition: background 0.2s;
        }

        .btn-payment:hover {
            background: var(--primary-hover);
            color: #fff;
        }

        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control-custom {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control-custom.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            font-size: 0.78rem;
        }

        /* Responsive */
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
            .order-summary {
                position: static;
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
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="brand-icon"><i class="bi bi-box-seam"></i></span>
                OSPEK Store
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
                            <li><a class="dropdown-item py-2" href="#">Atribut Wajib</a></li>
                            <li><a class="dropdown-item py-2" href="#">Alat Tulis</a></li>
                            <li><a class="dropdown-item py-2" href="#">Paket Bundling</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="#">Aksesoris</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="search-bar mx-auto">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" placeholder="Cari perlengkapan OSPEK...">
                </div>

                <div class="d-flex align-items-center gap-1 ms-lg-3 mt-3 mt-lg-0">
                    <button class="nav-icon-btn" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                    </button>
                    <button class="nav-icon-btn" title="Wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <button class="nav-icon-btn" title="Keranjang" data-bs-toggle="offcanvas" data-bs-target="#cartDrawer">
                        <i class="bi bi-bag"></i>
                        <span class="badge-counter" id="cartBadge">2</span>
                    </button>
                    <div class="user-avatar ms-2" title="Profil">AR</div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center hero-content">
                <div class="col-lg-6">
                    <span class="hero-badge"><i class="bi bi-stars me-1"></i> OSPEK 2026 Resmi</span>
                    <h1 class="hero-title">Perlengkapan OSPEK 2026 Ready!</h1>
                    <p class="hero-subtitle">Dapatkan paket lengkap sesuai fakultasmu tanpa ribet. Kualitas terjamin, pengiriman cepat ke seluruh kampus.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <button class="btn-primary-custom">Belanja Sekarang</button>
                        <button class="btn-outline-custom">Lihat Katalog</button>
                    </div>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="hero-image-wrap">
                        <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/1e6001c79-70fb-42e5-8e93-22f4eb6dee3e.png" alt="OSPEK Kit Bundle">
                    </div>
                </div>
            </div>
        </div>

        <!-- Countdown Banner -->
        <div class="countdown-banner">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="countdown-label">
                        <i class="bi bi-lightning-charge-fill flash-icon"></i>
                        Flash Sale Hari Ini — Berakhir dalam
                    </div>
                    <div class="countdown-timer">
                        <div class="countdown-box">
                            <span id="cdHours">08</span>
                            <span class="unit">Jam</span>
                        </div>
                        <div class="countdown-box">
                            <span id="cdMinutes">45</span>
                            <span class="unit">Menit</span>
                        </div>
                        <div class="countdown-box">
                            <span id="cdSeconds">22</span>
                            <span class="unit">Detik</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Grid -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Produk Terlaris</h2>
            <p class="section-subtitle">Paket terlengkap yang paling banyak dipilih mahasiswa baru</p>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <!-- Product 1 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge discount">Diskon 15%</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Paket OSPEK Lengkap">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Paket OSPEK Lengkap - Navy Blue Edition</h3>
                            <div class="product-faculty">Fakultas Ekonomi & Bisnis</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.9 (238)</span>
                            </div>
                            <div class="product-price">
                                Rp 150.000
                                <span class="original">Rp 175.000</span>
                            </div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge">Wajib</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Atribut Wajib">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Atribut Wajib OSPEK - Kemeja + ID Card</h3>
                            <div class="product-faculty">Fakultas Teknik</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.8 (184)</span>
                            </div>
                            <div class="product-price">Rp 120.000</div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge discount">Diskon 10%</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Alat Tulis Set">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Set Alat Tulis Premium - Notebook + Pulpen</h3>
                            <div class="product-faculty">Fakultas Hukum</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.7 (142)</span>
                            </div>
                            <div class="product-price">
                                Rp 85.000
                                <span class="original">Rp 95.000</span>
                            </div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge">Best Seller</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Paket Bundling">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Paket Bundling Hemat - All in One</h3>
                            <div class="product-faculty">Fakultas Kedokteran</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>5.0 (312)</span>
                            </div>
                            <div class="product-price">Rp 225.000</div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge">Wajib</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Tote Bag">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Tote Bag OSPEK - Canvas Premium</h3>
                            <div class="product-faculty">Fakultas Ilmu Sosial</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.6 (98)</span>
                            </div>
                            <div class="product-price">Rp 75.000</div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge discount">Diskon 20%</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Jaket OSPEK">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Jaket Hoodie OSPEK 2026 - Unisex</h3>
                            <div class="product-faculty">Fakultas MIPA</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.9 (276)</span>
                            </div>
                            <div class="product-price">
                                Rp 180.000
                                <span class="original">Rp 225.000</span>
                            </div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge">Baru</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="ID Card Holder">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">ID Card Holder + Lanyard Custom</h3>
                            <div class="product-faculty">Fakultas Pertanian</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.5 (67)</span>
                            </div>
                            <div class="product-price">Rp 45.000</div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="col">
                    <div class="product-card">
                        <div class="product-image-wrap">
                            <span class="product-badge discount">Diskon 10%</span>
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" alt="Notebook">
                        </div>
                        <div class="product-body">
                            <h3 class="product-title">Notebook A5 Hardcover - 200 Halaman</h3>
                            <div class="product-faculty">Fakultas Sastra</div>
                            <div class="product-rating">
                                <i class="bi bi-star-fill star"></i>
                                <span>4.8 (156)</span>
                            </div>
                            <div class="product-price">
                                Rp 65.000
                                <span class="original">Rp 72.000</span>
                            </div>
                            <button class="btn-add-cart" onclick="addToCart()">+ Keranjang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout Section -->
    <section class="checkout-section">
        <div class="container">
            <h2 class="section-title mb-4">Checkout</h2>
            <div class="row g-4">
                <!-- Left Column -->
                <div class="col-lg-7">
                    <!-- Alamat Pengiriman -->
                    <div class="checkout-card">
                        <div class="checkout-card-title">
                            <span class="step">1</span>
                            Alamat Pengiriman
                        </div>

                        <div class="address-card active" onclick="selectAddress(this)">
                            <div class="radio"></div>
                            <div class="flex-grow-1">
                                <div class="address-name">Ahmad Rizki <span class="badge bg-light text-dark fw-normal ms-2">Rumah</span></div>
                                <div class="address-detail">Jl. Merdeka No. 45, RT 03/RW 07, Kelurahan Sukamaju, Kecamatan Pancoran, Jakarta Selatan 12780</div>
                                <div class="address-phone"><i class="bi bi-telephone me-1"></i>0812-3456-7890</div>
                            </div>
                        </div>

                        <div class="address-card mt-3" onclick="selectAddress(this)">
                            <div class="radio"></div>
                            <div class="flex-grow-1">
                                <div class="address-name">Ahmad Rizki <span class="badge bg-light text-dark fw-normal ms-2">Kos</span></div>
                                <div class="address-detail">Kos Melati, Jl. Kampus Raya No. 12, Depok, Jawa Barat 16424</div>
                                <div class="address-phone"><i class="bi bi-telephone me-1"></i>0812-3456-7890</div>
                            </div>
                        </div>

                        <a href="#" class="link-primary mt-3 d-inline-block">
                            <i class="bi bi-plus-circle me-1"></i> Pilih Alamat Lain
                        </a>
                    </div>

                    <!-- Detail Produk -->
                    <div class="checkout-card">
                        <div class="checkout-card-title">
                            <span class="step">2</span>
                            Detail Produk
                        </div>

                        <div class="checkout-item">
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" class="checkout-item-img" alt="">
                            <div>
                                <div class="checkout-item-title">Paket OSPEK Lengkap - Navy Blue Edition</div>
                                <div class="checkout-item-variant">Varian: Fakultas Ekonomi & Bisnis · Size: L</div>
                                <div class="checkout-item-variant mt-1">Qty: 1</div>
                            </div>
                            <div class="checkout-item-price">Rp 150.000</div>
                        </div>

                        <div class="checkout-item">
                            <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" class="checkout-item-img" alt="">
                            <div>
                                <div class="checkout-item-title">Set Alat Tulis Premium - Notebook + Pulpen</div>
                                <div class="checkout-item-variant">Varian: Fakultas Hukum</div>
                                <div class="checkout-item-variant mt-1">Qty: 2</div>
                            </div>
                            <div class="checkout-item-price">Rp 170.000</div>
                        </div>
                    </div>

                    <!-- Kurir & Pengiriman -->
                    <div class="checkout-card">
                        <div class="checkout-card-title">
                            <span class="step">3</span>
                            Kurir & Pengiriman
                        </div>

                        <div class="courier-option active" onclick="selectCourier(this)">
                            <div class="radio"></div>
                            <div>
                                <div class="courier-name">Instant (Same Day)</div>
                                <div class="courier-desc">Tiba hari ini sebelum 21:00</div>
                            </div>
                            <div class="courier-price">Rp 25.000</div>
                        </div>

                        <div class="courier-option" onclick="selectCourier(this)">
                            <div class="radio"></div>
                            <div>
                                <div class="courier-name">Regular (2-3 Hari)</div>
                                <div class="courier-desc">Estimasi tiba 15-16 Agustus 2026</div>
                            </div>
                            <div class="courier-price">Rp 12.000</div>
                        </div>

                        <div class="courier-option" onclick="selectCourier(this)">
                            <div class="radio"></div>
                            <div>
                                <div class="courier-name">Next Day</div>
                                <div class="courier-desc">Tiba besok sebelum 18:00</div>
                            </div>
                            <div class="courier-price">Rp 18.000</div>
                        </div>
                    </div>

                    <!-- Form Data Pemesan -->
                    <div class="checkout-card">
                        <div class="checkout-card-title">
                            <span class="step">4</span>
                            Catatan Pesanan
                        </div>
                        <form id="noteForm" novalidate>
                            <div class="mb-3">
                                <label class="form-label-custom" for="orderNote">Catatan untuk penjual (opsional)</label>
                                <textarea class="form-control form-control-custom" id="orderNote" rows="3" placeholder="Contoh: Tolong dikemas dengan rapi..."></textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom" for="buyerName">Nama Penerima *</label>
                                    <input type="text" class="form-control form-control-custom" id="buyerName" required>
                                    <div class="invalid-feedback">Nama penerima wajib diisi</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom" for="buyerPhone">No. Telepon *</label>
                                    <input type="tel" class="form-control form-control-custom" id="buyerPhone" required>
                                    <div class="invalid-feedback">Nomor telepon wajib diisi</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-5">
                    <div class="order-summary checkout-card">
                        <div class="checkout-card-title">
                            <i class="bi bi-receipt"></i>
                            Ringkasan Pesanan
                        </div>

                        <div class="summary-row">
                            <span class="label">Total Harga (3 produk)</span>
                            <span class="value">Rp 320.000</span>
                        </div>
                        <div class="summary-row">
                            <span class="label">Ongkos Kirim</span>
                            <span class="value" id="summaryShipping">Rp 25.000</span>
                        </div>
                        <div class="summary-row discount">
                            <span class="label">Diskon Flash Sale</span>
                            <span class="value">- Rp 25.000</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-total">
                            <span class="label">Total Belanja</span>
                            <span class="value">Rp 320.000</span>
                        </div>

                        <button class="btn-payment">
                            <i class="bi bi-credit-card me-2"></i>
                            Pilih Pembayaran
                        </button>

                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 0.8rem;">
                                <i class="bi bi-shield-check"></i>
                                <span>Pembayaran aman & terenkripsi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-4">
        <div class="container text-center text-muted" style="font-size: 0.85rem;">
            © 2026 OSPEK Kit Store. All rights reserved.
        </div>
    </footer>

    <!-- Offcanvas Cart Drawer -->
    <div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="cartDrawer">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Keranjang Belanja <span class="text-muted fw-normal" style="font-size: 0.9rem;">(2 item)</span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="cart-items" id="cartItems">
            <!-- Cart Item 1 -->
            <div class="cart-item">
                <img src="https://image.qwenlm.ai/public_source/996b991c-7ca7-43ca-b9f7-315464fc8927/10a68108d-4190-49cb-b08d-b6c443ae0714.png" class="cart-item-img" alt="">
                <div class="cart-item-info">
                    <div class="cart-item-title">Paket OSPEK Lengkap - Navy Blue</div>
                    <div class="cart-item-variant">Fakultas Ekonomi · Size: L</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="qty-control">
                            <button clas... (8 KB left)
