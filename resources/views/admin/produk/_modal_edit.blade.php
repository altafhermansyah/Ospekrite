<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="modalEditProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalEditProdukLabel"><i class="bi bi-pencil-square me-2"></i>Edit Produk Satuan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formEditProduk" action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="modal-body px-4">

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="edit_nama_produk">Nama Produk</label>
              <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk" required>
              <div class="invalid-feedback">Nama produk wajib diisi.</div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="edit_id_kategori">Kategori</label>
              <select class="form-select" id="edit_id_kategori" name="id_kategori" required>
                <option value="" disabled>-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                  <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback">Silakan pilih kategori produk.</div>
            </div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="edit_harga_dasar">Harga Dasar (Rp)</label>
              <input type="number" class="form-control" id="edit_harga_dasar" name="harga_dasar" min="0" required>
              <div class="invalid-feedback">Harga dasar valid wajib diisi.</div>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label fw-semibold" for="edit_gambar_produk">Ganti Foto Produk</label>
              <input type="file" class="form-control" id="edit_gambar_produk" name="gambar_produk" accept="image/*">
              <div class="text-muted small mt-1">Kosongkan jika tidak ingin mengubah gambar di server.</div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold" for="edit_deskripsi">Deskripsi Produk</label>
            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
          </div>

          <hr>

          <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-tags me-2"></i>Manajemen Varian Ukuran & Stok</h6>
              <p class="text-muted small mb-0">Hapus baris jika ukuran tersebut sudah tidak diproduksi lagi.</p>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm fw-semibold" id="btnEditTambahVarian">
              <i class="bi bi-plus-lg"></i> Tambah Baris Varian
            </button>
          </div>

          <div id="wrapperEditVarian">
            </div>

        </div>

        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    let editVariantIndex = 0;
    const wrapper = document.getElementById('wrapperEditVarian');
    const btnTambah = document.getElementById('btnEditTambahVarian');
    const form = document.getElementById('formEditProduk');

    // Listener Event Delegasi untuk menangkap klik tombol Edit di tabel
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-edit-produk');
      if (btn) {
        // 1. Ambil data dari atribut tombol
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const kategori = btn.getAttribute('data-kategori');
        const harga = btn.getAttribute('data-harga');
        const deskripsi = btn.getAttribute('data-deskripsi');
        const variants = JSON.parse(btn.getAttribute('data-variants'));

        // 2. Set Action Form secara dinamis menuju rute update Laravel
        form.action = `/produk/${id}`;

        // 3. Isi nilai input text/select
        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_id_kategori').value = kategori;
        document.getElementById('edit_harga_dasar').value = harga;
        document.getElementById('edit_deskripsi').value = deskripsi;

        // 4. Kosongkan wadah varian lama dan render varian produk ini
        wrapper.innerHTML = '';
        editVariantIndex = 0;

        variants.forEach(function (v) {
          addVariantRow(v.id_varian, v.nama_varian, v.stok, v.harga_tambahan);
        });

        // Tampilkan modal secara manual
        const modal = new bootstrap.Modal(document.getElementById('modalEditProduk'));
        modal.show();
      }
    });

    // Handle tombol tambah baris baru saat edit
    btnTambah.addEventListener('click', function () {
      addVariantRow('', '', 0, 0);
    });

    // Handle hapus baris varian
    wrapper.addEventListener('click', function (e) {
      if (e.target.closest('.btn-hapus-edit-varian')) {
        const rows = wrapper.querySelectorAll('.variant-edit-row');
        if (rows.length > 1) {
          e.target.closest('.variant-edit-row').remove();
        } else {
          alert('Produk wajib memiliki minimal 1 varian ukuran!');
        }
      }
    });

    // Fungsi helper untuk mencetak baris input varian
    function addVariantRow(idVarian, namaVarian, stok, hargaTambahan) {
      const row = document.createElement('div');
      row.className = 'row g-2 align-items-center mb-2 variant-edit-row';
      row.innerHTML = `
        <input type="hidden" name="variants[${editVariantIndex}][id_varian]" value="${idVarian}">

        <div class="col-4">
          <input type="text" class="form-control form-control-sm" name="variants[${editVariantIndex}][nama_varian]" value="${namaVarian}" placeholder="Ukuran" required>
        </div>
        <div class="col-3">
          <input type="number" class="form-control form-control-sm" name="variants[${editVariantIndex}][stok]" value="${stok}" placeholder="Stok" min="0" required>
        </div>
        <div class="col-4">
          <input type="number" class="form-control form-control-sm" name="variants[${editVariantIndex}][harga_tambahan]" value="${hargaTambahan}" placeholder="+ Harga" min="0">
        </div>
        <div class="col-1 text-center">
          <button type="button" class="btn btn-sm text-danger btn-hapus-edit-varian"><i class="bi bi-trash-fill"></i></button>
        </div>
      `;
      wrapper.appendChild(row);
      editVariantIndex++;
    }
  });
</script>
@endpush
