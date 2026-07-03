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
                    <p class="text-muted mb-0">Pantau pesanan masuk, validasi pembayaran maba, dan perbarui status
                        pengambilan kit.</p>
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
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Daftar Pre-Order
                            Ospek Kit</span></h2>
                    <p class="text-muted mb-0">Menampilkan seluruh riwayat checkout mahasiswa.</p>
                </div>
                <input class="form-control form-control-sm table-search" type="search"
                    placeholder="Cari nomor invoice atau nama..." data-table-search="ordersTable"
                    aria-label="Search orders">
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
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="fw-semibold text-primary">#{{ $order->no_invoice ?? 'N/A' }}</td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <p class="fw-semibold mb-0">{{ $order->nama_pembeli }}</p>
                                            <p class="text-muted small mb-0">{{ $order->nim }} • {{ $order->fakultas }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="fw-semibold text-body">
                                    Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
                                </td>

                                <td>
                                    @switch($order->status_payment->value ?? $order->status_payment)
                                        @case('lunas')
                                            <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i> Lunas</span>
                                        @break

                                        @case('ditolak')
                                            <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                        @break

                                        @case('menunggu_validasi')
                                            <span class="badge text-bg-warning text-dark"><i class="bi bi-clock me-1"></i> Perlu
                                                Validasi</span>
                                        @break

                                        @case('expired')
                                            <span class="badge text-bg-dark"><i class="bi bi-exclamation-circle me-1"></i>
                                                Expired</span>
                                        @break

                                        @default
                                            <span class="badge text-bg-secondary"><i class="bi bi-wallet2 me-1"></i> Belum
                                                Bayar</span>
                                    @endswitch
                                </td>

                                <td>
                                    @switch($order->status_order->value ?? $order->status_order)
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

                                <td class="text-center">
                                    <button type="button" class="btn btn-light btn-sm fw-medium btn-detail-order"
                                        data-id="{{ $order->id_order }}" data-invoice="{{ $order->no_invoice }}"
                                        data-nama="{{ $order->nama_pembeli }}" data-nim="{{ $order->nim }}"
                                        data-fakultas="{{ $order->fakultas }}" data-whatsapp="{{ $order->no_whatsapp }}"
                                        data-email="{{ $order->email ?? '-' }}"
                                        data-tagihan="Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}"
                                        data-ptype="{{ strtoupper(str_replace('_', ' ', $order->payment_type->value ?? $order->payment_type)) }}"
                                        data-spayment="{{ $order->status_payment->value ?? $order->status_payment }}"
                                        data-sorder="{{ $order->status_order->value ?? $order->status_order }}"
                                        data-catatan="{{ $order->catatan ?? 'Tidak ada catatan khusus.' }}"
                                        data-bukti="{{ $order->pembayaran && $order->pembayaran->bukti_transfer ? asset('storage/' . $order->pembayaran->bukti_transfer) : '' }}">
                                        <i class="bi bi-eye me-1"></i> Detail & Validasi
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-cart-x d-block mb-2" style="font-size: 2.5rem;"></i> Belum ada transaksi
                                        pre-order yang masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="modal fade" id="modalDetailOrder" tabindex="-1" aria-labelledby="modalDetailOrderLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="modalDetailOrderLabel"><i class="bi bi-receipt me-2"></i>Rincian &
                            Validasi Invoice <span id="detInvoice" class="text-primary"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="formUpdateStatusOrder" action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body px-4">
                            <div class="row">
                                <div class="col-12 col-md-6 border-end">
                                    <div class="mb-3">
                                        <label class="small text-muted d-block mb-1">Identitas Mahasiswa</label>
                                        <div class="p-2 bg-light rounded border">
                                            <strong id="detNama" class="d-block text-dark"></strong>
                                            <span id="detNimProdi" class="small text-muted"></span>
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <label class="small text-muted">No. WhatsApp</label>
                                            <p id="detWhatsapp" class="fw-semibold mb-0 text-success"></p>
                                        </div>
                                        <div class="col-6">
                                            <label class="small text-muted">Total Tagihan</label>
                                            <p id="detTagihan" class="fw-semibold mb-0 text-dark"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small text-muted">Metode Pembayaran</label>
                                        <p id="detPtype" class="fw-semibold mb-0 text-primary"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small text-muted">Catatan Tambahan</label>
                                        <p id="detCatatan"
                                            class="fst-italic border-start border-3 ps-2 py-1 text-muted small bg-light"></p>
                                    </div>

                                    <div class="mb-1" id="wrapperBukti">
                                        <label class="small text-muted d-block text-start mb-1">Lampiran Bukti Transfer</label>
                                        <div class="text-center">
                                            <img id="detBuktiImg" src="" class="img-fluid rounded border shadow-sm"
                                                alt="Bukti Transfer"
                                                style="max-height: 200px; width: 100%; object-fit: contain; background-color: #f8f9fa;">
                                            <p id="detNoBukti"
                                                class="text-muted small mt-2 mb-0 fst-italic bg-light p-2 border rounded">Maba
                                                belum mengunggah foto struk transfer.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 ps-md-4 pt-3 pt-md-0">
                                    <h6 class="fw-bold text-dark mb-3"><i
                                            class="bi bi-shield-check me-2 text-primary"></i>Panel Validasi Pengelola</h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small" for="edit_status_payment">Status
                                            Pembayaran</label>
                                        <select class="form-select form-select-sm" id="edit_status_payment"
                                            name="status_payment" required>
                                            <option value="belum_bayar">Belum Bayar</option>
                                            <option value="menunggu_validasi">Menunggu Validasi</option>
                                            <option value="lunas">Lunas</option>
                                            <option value="ditolak">Ditolak</option>
                                            <option value="expired">Expired</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small" for="edit_status_order">Status Progress
                                            Alur Order</label>
                                        <select class="form-select form-select-sm" id="edit_status_order" name="status_order"
                                            required>
                                            <option value="pending">Pending</option>
                                            <option value="diproses">Diproses Vendor</option>
                                            <option value="siap_diambil">Ready di Stand</option>
                                            <option value="selesai">Sudah Diambil</option>
                                            <option value="batal">Dibatalkan</option>
                                        </select>
                                    </div>

                                    <div class="alert alert-warning py-2 px-3 small border-0 mb-0 mt-4">
                                        <i class="bi bi-info-circle-fill me-1"></i> Perubahan status di panel ini akan langsung
                                        memengaruhi kuota varian stok produk.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-outline-secondary btn-sm px-3"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold"><i
                                    class="bi bi-save me-1"></i> Simpan Pembaruan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formStatus = document.getElementById('formUpdateStatusOrder');

                document.addEventListener('click', function(e) {
                    const btn = e.target.closest('.btn-detail-order');
                    if (btn) {
                        const id = btn.getAttribute('data-id');
                        const invoice = btn.getAttribute('data-invoice');
                        const nama = btn.getAttribute('data-nama');
                        const nim = btn.getAttribute('data-nim');
                        const fakultas = btn.getAttribute('data-fakultas');
                        const whatsapp = btn.getAttribute('data-whatsapp');
                        const tagihan = btn.getAttribute('data-tagihan');
                        const ptype = btn.getAttribute(
                        'data-ptype'); // Berisi string "QRIS STATIS" atau "QRIS DINAMIS"
                        const catatan = btn.getAttribute('data-catatan');
                        const bukti = btn.getAttribute('data-bukti');

                        const statusPayment = btn.getAttribute('data-spayment');
                        const statusOrder = btn.getAttribute('data-sorder');

                        formStatus.action = `/orders/${id}/status`;

                        document.getElementById('detInvoice').textContent = invoice ? '#' + invoice :
                            '#PENDING_KEY';
                        document.getElementById('detNama').textContent = nama;
                        document.getElementById('detNimProdi').textContent =
                            `${nim} — ${btn.getAttribute('data-fakultas')}`;
                        document.getElementById('detWhatsapp').textContent = whatsapp;
                        document.getElementById('detTagihan').textContent = tagihan;
                        document.getElementById('detPtype').textContent = ptype;
                        document.getElementById('detCatatan').textContent = catatan;

                        document.getElementById('edit_status_payment').value = statusPayment;
                        document.getElementById('edit_status_order').value = statusOrder;

                        // LOGIKA TERBARU: Sembunyikan lampiran jika tipe QRIS DINAMIS
                        const wrapperBukti = document.getElementById('wrapperBukti');
                        const imgEl = document.getElementById('detBuktiImg');
                        const txtEl = document.getElementById('detNoBukti');

                        if (ptype === 'QRIS DINAMIS') {
                            wrapperBukti.classList.add('d-none'); // Menyembunyikan seluruh section bukti
                        } else {
                            wrapperBukti.classList.remove(
                            'd-none'); // Menampilkan kembali jika metodenya statis

                            // Kelola isi internal gambar struk jika metode statis
                            if (bukti) {
                                imgEl.src = bukti;
                                imgEl.classList.remove('d-none');
                                txtEl.classList.add('d-none');
                            } else {
                                imgEl.src = '';
                                imgEl.classList.add('d-none');
                                txtEl.classList.remove('d-none');
                            }
                        }

                        const modal = new bootstrap.Modal(document.getElementById('modalDetailOrder'));
                        modal.show();
                    }
                });
            });
        </script>
    @endpush
