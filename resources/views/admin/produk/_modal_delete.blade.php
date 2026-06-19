<div class="modal fade" id="modalHapusProduk" tabindex="-1" aria-labelledby="modalHapusProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-0 pt-4 px-4 pb-0">
        <h5 class="modal-title fw-bold text-danger" id="modalHapusProdukLabel">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>Hapus Produk?
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formHapusProduk" action="" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-body px-4 pt-3 pb-4">
          <p class="text-muted mb-0">
            Apakah Anda yakin ingin menghapus produk <strong id="textNamaProdukHapus" class="text-dark"></strong>?
          </p>
          <p class="text-danger small mb-0 mt-2 fw-medium">
            <i class="bi bi-info-circle me-1"></i> Tindakan ini tidak dapat dibatalkan. Seluruh data kuota varian ukuran terkait akan ikut terhapus otomatis dari sistem.
          </p>
        </div>

        <div class="modal-footer border-0 bg-light px-4 py-3">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold">
            <i class="bi bi-trash me-1"></i> Ya, Hapus
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const formHapus = document.getElementById('formHapusProduk');
    const textNama = document.getElementById('textNamaProdukHapus');

    // Menerima delegasi klik tombol hapus dari tabel
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-delete-produk');
      if (btn) {
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');

        // 1. Set action URL ke route destroy Laravel
        formHapus.action = `/produk/${id}`;

        // 2. Tampilkan nama produk di teks konfirmasi
        textNama.textContent = nama;

        // 3. Picu modal untuk muncul
        const modal = new bootstrap.Modal(document.getElementById('modalHapusProduk'));
        modal.show();
      }
    });
  });
</script>
@endpush
