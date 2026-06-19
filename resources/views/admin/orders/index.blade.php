@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="container-fluid px-3 px-lg-4 py-4">

  <div class="page-heading">
    <div class="page-heading-copy">
      <span class="page-icon"><i class="bi bi-cart-check" aria-hidden="true"></i></span>
      <div>
        <p class="eyebrow mb-1">Transaksi</p>
        <h1 class="h3 mb-1">Manajemen Pesanan</h1>
        <p class="text-muted mb-0">Pantau pesanan masuk, validasi bukti pembayaran maba, dan perbarui status pengambilan kit.</p>
      </div>
    </div>
    <div class="heading-actions">
      <button class="btn btn-outline-secondary btn-sm" type="button">
        <i class="bi bi-download me-1" aria-hidden="true"></i> Export Excel
      </button>
    </div>
  </div>

  <section class="panel mt-3">
    <div class="panel-header">
      <div>
        <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Daftar Pre-Order Ospek Kit</span></h2>
        <p class="text-muted mb-0">Menampilkan seluruh riwayat checkout mahasiswa.</p>
      </div>
      <input class="form-control form-control-sm table-search" type="search" placeholder="Cari nomor invoice atau nama..." data-table-search="ordersTable" aria-label="Search orders">
    </div>

    <div class="table-responsive">
      <table class="table align-middle mb-0" id="ordersTable" data-searchable-table>
        <thead>
          <tr>
            <th>Invoice</th>
            <th>Mahasiswa (Pemesan)</th>
            <th>Total Tagihan</th>
            <th>Status Pembayaran</th>
            <th>Status Order</th>
            <th>Tanggal Order</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            <tr>
              <td class="fw-semibold text-primary">#{{ $order->no_invoice }}</td>

              <td>
                <div class="d-flex align-items-center gap-2">
                  <div>
                    <p class="fw-semibold mb-0">{{ $order->user->nama_lengkap ?? 'Guest / Mahasiswa Dihapus' }}</p>
                    <p class="text-muted small mb-0">{{ $order->user->nim ?? '-' }} • {{ $order->user->program_studi ?? '-' }}</p>
                  </div>
                </div>
              </td>

              <td class="fw-semibold text-body">
                Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
              </td>

              <td>
                @if($order->pembayaran)
                  @if($order->pembayaran->status_pembayaran === 'lunas')
                    <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i> Lunas</span>
                  @elseif($order->pembayaran->status_pembayaran === 'ditolak')
                    <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                  @else
                    <span class="badge text-bg-warning text-dark"><i class="bi bi-clock me-1"></i> Perlu Validasi</span>
                  @endif
                @else
                  <span class="badge text-bg-secondary"><i class="bi bi-wallet2 me-1"></i> Belum Bayar</span>
                @endif
              </td>

              <td>
                @switch($order->status_order)
                  @case('pending')
                    <span class="badge text-bg-light border text-muted">Pending</span>
                    @break
                  @case('diproses')
                    <span class="badge text-bg-info text-white">Diproses Vendor</span>
                    @break
                  @case('siap_diambil')
                    <span class="badge text-bg-warning text-dark">Ready di Stand</span>
                    @break
                  @case('selesai')
                    <span class="badge text-bg-success">Sudah Diambil</span>
                    @break
                  @case('batal')
                    <span class="badge text-bg-danger">Dibatalkan</span>
                    @break
                @endswitch
              </td>

              <td class="text-muted small">
                {{ $order->tanggal_order ? date('d M 2026, H:i', strtotime($order->tanggal_order)) : '-' }}
              </td>

              <td class="text-end">
                <a href="#" class="btn btn-light btn-sm fw-medium">
                  <i class="bi bi-eye me-1"></i> Detail
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                <i class="bi bi-cart-x d-block mb-2" style="font-size: 2.5rem;"></i>
                Belum ada transaksi pre-order yang masuk.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>
</div>
@endsection
