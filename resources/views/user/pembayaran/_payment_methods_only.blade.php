{{--
    Partial: Payment Methods ONLY (no upload form)
    Included by: pembayaran/index.blade.php
    Used for: menunggu_validasi state (already uploaded, just showing bank info)
--}}
<div class="card-section">
    <h2 class="card-section-title"><i class="bi bi-bank"></i> Rekening Tujuan Transfer</h2>

    @if($metodePembayaran->isEmpty())
        <p style="color: var(--text-muted); font-size: 0.9rem;">Data rekening belum tersedia. Hubungi panitia.</p>
    @else
        <div class="metode-list">
            @foreach($metodePembayaran as $metode)
                <div class="metode-card">
                    <div>
                        <div class="metode-bank-name">{{ $metode->nama_bank }}</div>
                        <div class="metode-bank-detail">a.n. {{ $metode->atas_nama }}</div>
                    </div>
                    <div class="metode-rekening">{{ $metode->no_rekening }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
