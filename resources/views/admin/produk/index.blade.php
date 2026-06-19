@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Katalog master</p>
                    <h1 class="h3 mb-1">Manajemen Produk</h1>
                    <p class="text-muted mb-0">Kelola item produk Ospek Kit satuan, harga dasar, serta pantau kuota varian
                        stok.</p>
                </div>
            </div>
            <div class="heading-actions">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambahProduk">
                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Tambah Produk
                </button>
            </div>
        </div>

        <section class="panel mt-3">
            <div class="panel-header">
                <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Daftar Produk
                            Satuan</span></h2>
                    <p class="text-muted mb-0">Total terdapat {{ $produks->count() }} item terdaftar.</p>
                </div>
                <input class="form-control form-control-sm table-search" type="search"
                    placeholder="Cari nama produk atau kategori..." data-table-search="productsTable"
                    aria-label="Search products">
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="productsTable" data-searchable-table>
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga Dasar</th>
                            <th>Status Stok Varian</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $produk)
                            <tr>
                                <td class="fw-semibold text-muted">#PRD-{{ $produk->id_produk }}</td>

                                <td>
                                    <div class="table-media">
                                        <img class="product-thumb rounded"
                                            src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : asset('assets/images/ecommerce/product-1.jpg') }}"
                                            alt="{{ $produk->nama_produk }}">
                                        <div>
                                            <span class="d-block fw-semibold">{{ $produk->nama_produk }}</span>
                                            <small class="text-muted d-block text-truncate"
                                                style="max-width: 250px;">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span
                                        class="badge text-bg-light border px-2 py-1">{{ $produk->kategori->nama_kategori ?? 'Tanpa Kategori' }}</span>
                                </td>

                                <td class="fw-semibold text-body">
                                    Rp {{ number_format($produk->harga_dasar, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if ($produk->varians->count() > 0)
                                        @php $totalStok = $produk->varians->sum('stok'); @endphp

                                        <div class="d-flex flex-wrap gap-1 mb-1">
                                            @foreach ($produk->varians as $varian)
                                                <span
                                                    class="badge {{ $varian->stok <= 5 ? 'text-bg-danger' : 'text-bg-secondary' }}"
                                                    style="font-size: 0.75rem;">
                                                    {{ $varian->nama_varian }}: {{ $varian->stok }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <small class="text-muted d-block fw-medium">Total Akumulasi:
                                            <strong>{{ $totalStok }} pcs</strong></small>
                                    @else
                                        <span class="badge text-bg-warning">Belum ada varian ukuran</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-light btn-sm text-primary btn-edit-produk"
                                            data-id="{{ $produk->id_produk }}" data-nama="{{ $produk->nama_produk }}"
                                            data-kategori="{{ $produk->id_kategori }}"
                                            data-harga="{{ $produk->harga_dasar }}"
                                            data-deskripsi="{{ $produk->deskripsi }}"
                                            data-variants="{{ $produk->varians->toJson() }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-light btn-sm text-danger btn-delete-produk"
                                            data-id="{{ $produk->id_produk }}" data-nama="{{ $produk->nama_produk }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-box-open d-block mb-2" style="font-size: 2rem;"></i>
                                    Belum ada data produk satuan yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    @include('admin.produk._modal_tambah')
    @include('admin.produk._modal_edit')
    @include('admin.produk._modal_delete')
@endsection
