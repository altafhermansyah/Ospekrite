<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="modalEditUserLabel"><i class="bi bi-person-gear me-2"></i>Edit Informasi Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formEditUser" action="" method="POST" class="needs-validation" novalidate>
        @csrf
        @method('PUT')

        <div class="modal-body px-4">
          <div class="mb-3">
            <label class="form-label fw-semibold" for="edit_nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-6">
              <label class="form-label fw-semibold" for="edit_nim">NIM / No. Registrasi</label>
              <input type="text" class="form-control" id="edit_nim" name="nim" required>
              <div class="invalid-feedback">NIM wajib diisi.</div>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold" for="edit_no_whatsapp">No. WhatsApp</label>
              <input type="text" class="form-control" id="edit_no_whatsapp" name="no_whatsapp" required>
              <div class="invalid-feedback">Nomor WhatsApp wajib diisi.</div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" for="edit_email">Alamat Email</label>
            <input type="email" class="form-control" id="edit_email" name="email">
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold" for="edit_fakultas">Fakultas</label>
            <input type="text" class="form-control" id="edit_fakultas" name="fakultas" required>
            <div class="invalid-feedback">Fakultas wajib diisi.</div>
          </div>

          @if(Auth::user()->role === 'dewa')
            <div class="mb-2">
              <label class="form-label fw-semibold" for="edit_role">Hak Akses (Role)</label>
              <select class="form-select" id="edit_role" name="role" required>
                <option value="mahasiswa">Mahasiswa (Maba)</option>
                <option value="admin">Panitia (Admin)</option>
                <option value="dewa">Super Admin (Dewa)</option>
              </select>
            </div>

            <div class="text-muted small">
              <i class="bi bi-info-circle"></i> Mengubah hak akses ke <strong>Admin/Dewa</strong> akan mengizinkan user tersebut masuk ke portal admin ini.
            </div>
          @else
            <input type="hidden" id="edit_role" name="role">
          @endif
        </div>

        <div class="modal-footer bg-light border-0">
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formEditUser');

    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-edit-user');
      if (btn) {
        // Tangkap atribut data dari tombol tabel
        const id = btn.getAttribute('data-id');
        const nama = btn.getAttribute('data-nama');
        const nim = btn.getAttribute('data-nim');
        const email = btn.getAttribute('data-email');
        const whatsapp = btn.getAttribute('data-whatsapp');
        const fakultas = btn.getAttribute('data-fakultas');
        const role = btn.getAttribute('data-role');

        form.action = `/users/${id}`;

        document.getElementById('edit_nama_lengkap').value = nama;
        document.getElementById('edit_nim').value = nim;
        document.getElementById('edit_no_whatsapp').value = whatsapp;
        document.getElementById('edit_email').value = email || '';
        document.getElementById('edit_fakultas').value = fakultas || '';
        document.getElementById('edit_role').value = role;

        // Buka modal
        const modal = new bootstrap.Modal(document.getElementById('modalEditUser'));
        modal.show();
      }
    });
  });
</script>
@endpush
