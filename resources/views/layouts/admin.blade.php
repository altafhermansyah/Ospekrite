<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Ospekrite professional admin dashboard template">

    <title>@yield('title', 'Dashboard') | Admin Ospekrite</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @stack('styles')
</head>

<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <aside class="admin-sidebar d-flex flex-column" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="{{ url('/dashboard') }}" aria-label="Admin Ospekrite dashboard">
                    <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
                    <span class="brand-copy">
                        <span class="brand-title">Admin Ospek</span>
                        <span class="brand-subtitle">Panel Panitia</span>
                    </span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ url('/dashboard') }}">
                    <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}"
                    href="{{ route('produk.index') }}">
                    <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                    <span class="nav-text">Manajemen Produk</span>
                </a>
                <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}"
                    href="{{ route('orders.index') }}">
                    <span class="nav-icon"><i class="bi bi-cart-check" aria-hidden="true"></i></span>
                    <span class="nav-text">Pesanan (Orders)</span>
                </a>
                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                    href="{{ route('users.index') }}">
                    <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="nav-text">Data Mahasiswa</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <span class="status-dot"></span>
                <span class="sidebar-footer-text">System running smoothly</span>
            </div>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-navbar navbar-expand bg-white">
                <div class="container-fluid px-3 px-lg-4">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar"
                        aria-expanded="true" aria-label="Toggle sidebar">
                        <span></span><span></span><span></span>
                    </button>

                    <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
                        <input class="form-control search-input" type="search"
                            placeholder="Cari invoice pesanan atau nama mahasiswa..." aria-label="Search">
                    </form>

                    <div class="navbar-actions ms-auto">
                        <button class="icon-button theme-toggle" type="button" data-theme-toggle
                            aria-label="Switch color theme" title="Switch color theme">
                            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                        </button>

                        <div class="dropdown">
                            <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}"
                                    alt="Admin Avatar">
                                <span
                                    class="profile-name d-none d-sm-inline">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            Sign out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="dashboard-content">
                @yield('content')
            </main>

            <footer class="admin-footer">
                <div class="container-fluid px-3 px-lg-4">
                    <span>Copyright &copy; {{ date('Y') }} Panitia Ospek.</span>
                </div>
            </footer>
        </div>
    </div>

    <script>
        window.adminHMDUser = {
            name: "{{ Auth::user()->nama_lengkap ?? 'Admin' }}",
            workspace: "{{ strtoupper(Auth::user()->role ?? 'Panitia') }}",
            avatar: "{{ asset('assets/images/avatar/avatar.jpg') }}"
        };
    </script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
