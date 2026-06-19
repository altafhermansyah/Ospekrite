<div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalTambahProdukLabel"><i class="bi bi-box-seam me-2"></i>Tambah Produk Satuan Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <div class="modal-body px-4">

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="nama_produk">Nama Produk</label>
              <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Contoh: Kaos Wajib Ospek 2026" required>
              <div class="invalid-feedback">Nama produk wajib diisi.</div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="id_kategori">Kategori</label>
              <select class="form-select" id="id_kategori" name="id_kategori" required>
                <option value="" selected disabled>-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                  <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">Silakan pilih kategori produk.</div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="harga_dasar">Harga Dasar (Rp)</label>
              <input type="number" class="form-control" id="harga_dasar" name="harga_dasar" placeholder="Contoh: 50000" min="0" required>
              <div class="invalid-feedback">Harga dasar valid wajib diisi.</div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="gambar_produk">Foto Produk</label>
              <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*">
              <div class="text-muted small mt-1">Format: JPG/PNG, Maksimal 2MB.</div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold" for="deskripsi">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan detail bahan, warna, atau ketentuan produk..."></textarea>
          </div>

          <hr>

          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-tags me-2"></i>Manajemen Varian Ukuran & Stok</h6>
              <p class="text-muted small mb-0">Wajib isi minimal 1 varian (Gunakan 'All Size' jika produk tidak memiliki ukuran).</p>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm fw-semibold" id="btnTambahVarian">
              <i class="bi bi-plus-lg"></i> Tambah Baris Varian
            </button>
          </div>

          <div id="wrapperVarian">
            <div class="row g-2 align-items-center mb-2 variant-row">
              <div class="col-4">
                <input type="text" class="form-control form-control-sm" name="variants[0][nama_varian]" placeholder="Ukuran (S, M, L, All Size)" required>
              </div>
              <div class="col-3">
                <input type="number" class="form-control form-control-sm" name="variants[0][stok]" placeholder="Kuota Stok" min="0" required>
              </div>
              <div class="col-4">
                <input type="number" class="form-control form-control-sm" name="variants[0][harga_tambahan]" placeholder="+ Tambahan Harga (Rp)" value="0" min="0">
              </div>
              <div class="col-1 text-center">
                <button type="button" class="btn btn-sm text-danger btn-hapus-varian" disabled><i class="bi bi-trash-fill"></i></button>
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let variantIndex = 1;
    const wrapper = document.getElementById('wrapperVarian');
    const btnTambah = document.getElementById('btnTambahVarian');

    // Handle Tambah Baris Varian
    btnTambah.addEventListener('click', function () {
      const row = document.createElement('div');
      row.className = 'row g-2 align-items-center mb-2 variant-row';
      row.innerHTML = `
        <div class="col-4">
          <input type="text" class="form-control form-control-sm" name="variants[${variantIndex}][nama_varian]" placeholder="Ukuran (S, M, L, All Size)" required>
        </div>
        <div class="col-3">
          <input type="number" class="form-control form-control-sm" name="variants[${variantIndex}][stok]" placeholder="Kuota Stok" min="0" required>
        </div>
        <div class="col-4">
          <input type="number" class="form-control form-control-sm" name="variants[${variantIndex}][harga_tambahan]" placeholder="+ Tambahan Harga (Rp)" value="0" min="0">
        </div>
        <div class="col-1 text-center">
          <button type="button" class="btn btn-sm text-danger btn-hapus-varian"><i class="bi bi-trash-fill"></i></button>
        </div>
      `;
      wrapper.appendChild(row);
      variantIndex++;
      toggleHapusButton();
    });

    // Handle Hapus Baris Varian
    wrapper.addEventListener('click', function (e) {
      if (e.target.closest('.btn-hapus-varian')) {
        const row = e.target.closest('.variant-row');
        row.remove();
        toggleHapusButton();
      }
    });

    function toggleHapusButton() {
      const rows = wrapper.querySelectorAll('.variant-row');
      const firstDeleteBtn = rows[0].querySelector('.btn-hapus-varian');
      if (rows.length === 1) {
        firstDeleteBtn.setAttribute('disabled', 'true');
      } else {
        firstDeleteBtn.removeAttribute('disabled');
      }
    }
  });
</script>
@endpush
