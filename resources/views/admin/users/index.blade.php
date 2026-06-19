@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Management</p>
                    <h1 class="h3 mb-1">Manajemen Pengguna</h1>
                    <p class="text-muted mb-0">Pantau data mahasiswa baru yang terdaftar, kelola hak akses panitia, dan lihat
                        rincian program studi.</p>
                </div>
            </div>
            <div class="heading-actions">
                <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i>
                    Export Data</a>
            </div>
        </div>

        <section class="row g-3 mt-1" aria-label="User summary">
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Total Pengguna</span>
                        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ $metrics['total'] }}</div>
                    <div class="metric-meta">
                        <span>Entitas akun terdaftar</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success">
                    <div class="metric-top">
                        <span class="metric-label">Mahasiswa Baru</span>
                        <span class="metric-icon"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ $metrics['mahasiswa'] }}</div>
                    <div class="metric-meta">
                        <span class="text-success">Target PO Kit</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning">
                    <div class="metric-top">
                        <span class="metric-label">Panitia (Admin)</span>
                        <span class="metric-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ $metrics['admin'] }}</div>
                    <div class="metric-meta">
                        <span>Operator sistem</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger">
                    <div class="metric-top">
                        <span class="metric-label">Super Admin (Dewa)</span>
                        <span class="metric-icon"><i class="bi bi-shield-lock" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ $metrics['dewa'] }}</div>
                    <div class="metric-meta">
                        <span class="text-danger">Akses penuh</span>
                    </div>
                </article>
            </div>
        </section>

        <section class="panel mt-3">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Daftar Pengguna
                            Sistem</span></h2>
                    <p class="text-muted mb-0">Gunakan kolom pencarian untuk menyaring NIM, Nama, atau Program Studi secara
                        instan.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <input class="form-control form-control-sm table-search" type="search" placeholder="Cari pengguna..."
                        data-table-search="usersTable" aria-label="Search users">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="usersTable" data-searchable-table>
                    <thead>
                        <tr>
                            <th scope="col">Nama & Email</th>
                            <th scope="col">NIM / No. Reg</th>
                            <th scope="col">No. WhatsApp</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Role</th>
                            <th scope="col">Terdaftar</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img class="avatar-img avatar-sm"
                                            src="{{ asset('assets/images/avatar/avatar.jpg') }}"
                                            alt="{{ $user->nama_lengkap }}">
                                        <div>
                                            <p class="fw-semibold mb-0">{{ $user->nama_lengkap }}</p>
                                            <p class="text-muted small mb-0">{{ $user->email ?? 'Tidak ada email' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="fw-medium text-body">{{ $user->nim }}</td>

                                <td>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->no_whatsapp) }}"
                                        target="_blank" class="text-decoration-none text-success fw-medium">
                                        <i class="bi bi-whatsapp me-1"></i> {{ $user->no_whatsapp }}
                                    </a>
                                </td>

                                <td class="text-muted">{{ $user->fakultas }}</td>

                                <td>
                                    @if ($user->role === 'dewa')
                                        <span class="badge text-bg-danger text-uppercase px-2 py-1">Dewa</span>
                                    @elseif($user->role === 'admin')
                                        <span class="badge text-bg-warning text-dark text-uppercase px-2 py-1">Admin</span>
                                    @else
                                        <span class="badge text-bg-success text-uppercase px-2 py-1">Mahasiswa</span>
                                    @endif
                                </td>

                                <td class="text-muted small">
                                    {{ $user->created_at ? date('d M 2026', strtotime($user->created_at)) : '-' }}
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-light btn-sm text-primary btn-edit-user"
                                            data-id="{{ $user->id_user }}" data-nama="{{ $user->nama_lengkap }}"
                                            data-nim="{{ $user->nim }}" data-email="{{ $user->email }}"
                                            data-whatsapp="{{ $user->no_whatsapp }}"
                                            data-fakultas="{{ $user->fakultas }}" data-role="{{ $user->role }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-people-fill d-block mb-2" style="font-size: 2.5rem;"></i>
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
                <p class="text-muted small mb-0">
                    Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari
                    {{ $users->total() }} pengguna
                </p>
                <nav aria-label="Users pagination">
                    {{ $users->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </section>
    </div>

@include('admin.users._modal_edit')
@endsection
