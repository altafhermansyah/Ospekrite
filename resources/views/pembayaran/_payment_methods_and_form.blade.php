{{--
    Partial: Payment Methods + Upload Form
    Included by: pembayaran/index.blade.php
    Used for: belum_bayar state and ditolak (re-upload) state
--}}

{{-- Payment Methods --}}
<div class="card-section">
    <h2 class="card-section-title"><i class="bi bi-bank"></i> Instruksi Pembayaran</h2>

    @if($metodePembayaran->isEmpty())
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            Data rekening belum tersedia. Hubungi panitia OSPEK Amerta 2026.
        </p>
    @else
        <div class="metode-list">
            @foreach($metodePembayaran as $metode)
                <div class="metode-card">
                    <div>
                        <div class="metode-bank-name">{{ $metode->nama_bank }}</div>
                        <div class="metode-bank-detail">a.n. {{ $metode->atas_nama }}</div>
                    </div>
                    <div class="metode-rekening" title="Klik untuk menyalin" onclick="copyText('{{ $metode->no_rekening }}', this)">
                        {{ $metode->no_rekening }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="transfer-warning">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>Transfer <strong>tepat sesuai nominal</strong> (Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}) agar mudah diverifikasi oleh panitia.</span>
        </div>
    @endif
</div>

{{-- Upload Form --}}
<div class="card-section">
    <h2 class="card-section-title"><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h2>

    <form id="payment-upload-form"
          method="POST"
          action="{{ route('pembayaran.store', $order->no_invoice) }}"
          enctype="multipart/form-data"
          @submit="handleSubmit">
        @csrf

        {{-- Nama Pengirim --}}
        <div class="form-group">
            <label for="nama_pengirim" class="form-label">
                Nama Pengirim (sesuai rekening) <span class="required">*</span>
            </label>
            <input type="text"
                   id="nama_pengirim"
                   name="nama_pengirim"
                   class="form-control {{ $errors->has('nama_pengirim') ? 'is-invalid' : '' }}"
                   value="{{ old('nama_pengirim') }}"
                   placeholder="Nama pemilik rekening pengirim"
                   maxlength="255"
                   required>
            @error('nama_pengirim')
                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        {{-- Bukti Transfer --}}
        <div class="form-group">
            <label class="form-label">
                Bukti Transfer <span class="required">*</span>
            </label>

            <div class="file-upload-area {{ $errors->has('bukti_transfer') ? 'is-invalid' : '' }}"
                 :class="{ 'drag-over': $el.classList.contains('drag-over') }"
                 x-on:dragover.prevent="$el.classList.add('drag-over')"
                 x-on:dragleave.prevent="$el.classList.remove('drag-over')"
                 x-on:drop.prevent="$el.classList.remove('drag-over'); $refs.fileInput.files = $event.dataTransfer.files; handleFileChange({target: $refs.fileInput})">

                <input type="file"
                       id="bukti_transfer"
                       name="bukti_transfer"
                       x-ref="fileInput"
                       accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                       @change="handleFileChange"
                       required>

                <template x-if="!previewUrl">
                    <div>
                        <i class="bi bi-cloud-upload file-upload-icon"></i>
                        <div class="file-upload-text">Klik atau seret file ke sini</div>
                        <div class="file-upload-hint">JPG, JPEG, PNG, WEBP · Maks 2 MB</div>
                    </div>
                </template>

                <template x-if="previewUrl">
                    <div>
                        <i class="bi bi-check-circle-fill" style="font-size:1.5rem;color:var(--success);"></i>
                        <div class="file-upload-text" style="margin-top:4px;" x-text="fileName"></div>
                        <div class="file-upload-hint">Klik untuk mengganti file</div>
                    </div>
                </template>
            </div>

            @error('bukti_transfer')
                <div class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        {{-- Image Preview --}}
        <template x-if="previewUrl">
            <div class="img-preview-container">
                <img :src="previewUrl" class="img-preview" alt="Preview bukti transfer">
            </div>
        </template>

        {{-- Submit --}}
        <button type="submit"
                class="btn-submit-payment"
                id="btn-submit-payment"
                :disabled="isSubmitting"
                style="margin-top: 20px;">
            <template x-if="!isSubmitting">
                <span><i class="bi bi-send-check"></i> Konfirmasi Pembayaran</span>
            </template>
            <template x-if="isSubmitting">
                <span><span class="spinner-icon"></span> Mengirim...</span>
            </template>
        </button>

        <p style="text-align:center;font-size:0.78rem;color:var(--text-muted);margin-top:10px;">
            Panitia akan memverifikasi bukti dalam <strong>1×24 jam</strong>.
        </p>
    </form>
</div>

<script>
    function copyText(text, el) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = el.textContent;
            el.textContent = '✓ Disalin!';
            el.style.color = 'var(--success)';
            setTimeout(() => {
                el.textContent = orig;
                el.style.color = '';
            }, 1800);
        });
    }
</script>
