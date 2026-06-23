<x-storefront-layout :title="'Detail Pesanan | ' . $order->no_invoice">
    <main class="layout-container" style="padding: 40px 20px 80px; max-width: 800px; margin: 0 auto; font-family: 'Inter', sans-serif;">
        
        @if(session('info'))
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; display: flex; gap: 8px; align-items: center;">
                <i class="bi bi-info-circle-fill"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        {{-- Order Header --}}
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid #f3f4f6; padding-bottom: 16px;">
                <div style="background: #eff6ff; color: var(--primary); width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <h1 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin: 0;">Detail Pesanan</h1>
                    <p style="font-size: 0.85rem; color: #6b7280; margin: 2px 0 0 0; font-family: monospace;">{{ $order->no_invoice }}</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 16px;">
                <div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 4px;">Tanggal Order</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #111827;">{{ $order->tanggal_order ? $order->tanggal_order->format('d M Y, H:i') : '-' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 4px;">Nama Pembeli</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #111827;">{{ $order->nama_pembeli }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 4px;">Fakultas</div>
                    <div style="font-size: 0.95rem; font-weight: 500; color: #111827;">{{ $order->fakultas }}</div>
                </div>
            </div>
        </div>

        @php
            $payStatus = $order->status_payment?->value ?? $order->status_payment;
            $orderStatus = $order->status_order?->value ?? $order->status_order;
        @endphp

        {{-- Status Timeline & Payment Badge (Alpine Component) --}}
        <div x-data="{
            currentStatus: '{{ $orderStatus }}',
            isBatal: '{{ $orderStatus }}' === 'batal',
            steps: [
                { id: 'pending', label: 'Pesanan Dibuat', desc: 'Menunggu konfirmasi pembayaran', icon: 'bi-journal-check' },
                { id: 'diproses', label: 'Diproses', desc: 'Pesanan sedang disiapkan', icon: 'bi-box-seam' },
                { id: 'siap_diambil', label: 'Siap Diambil', desc: 'Pesanan tersedia di lokasi', icon: 'bi-shop' },
                { id: 'selesai', label: 'Selesai', desc: 'Pesanan telah diambil', icon: 'bi-check-circle' }
            ],
            batalStep: { id: 'batal', label: 'Dibatalkan', desc: 'Pesanan telah dibatalkan', icon: 'bi-x-circle' },
            getStepIndex(status) {
                return this.steps.findIndex(s => s.id === status);
            },
            isActive(status) {
                if (this.isBatal) return status === 'pending' || status === 'batal';
                let currentIdx = this.getStepIndex(this.currentStatus);
                let thisIdx = this.getStepIndex(status);
                return thisIdx <= currentIdx;
            }
        }" style="background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #111827; margin: 0 0 8px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-geo-alt" style="color: var(--primary);"></i> Lacak Pesanan
                    </h2>
                </div>
                
                {{-- Payment Badge --}}
                <div style="text-align: right;">
                    <div style="font-size: 0.75rem; color: #6b7280; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; margin-bottom: 6px;">Status Pembayaran</div>
                    @if($payStatus === 'belum_bayar')
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #f3f4f6; color: #4b5563; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-clock"></i> Belum Bayar
                        </span>
                    @elseif($payStatus === 'menunggu_validasi')
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #fef9c3; color: #854d0e; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-hourglass-split"></i> Menunggu Validasi
                        </span>
                    @elseif($payStatus === 'lunas')
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #dcfce7; color: #166534; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-check-circle-fill"></i> Lunas
                        </span>
                    @elseif($payStatus === 'ditolak')
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #fee2e2; color: #991b1b; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-x-circle-fill"></i> Ditolak
                        </span>
                    @elseif($payStatus === 'expired')
                        <span style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px; background: #f3f4f6; color: #6b7280; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                            <i class="bi bi-slash-circle"></i> Kedaluwarsa
                        </span>
                    @endif
                </div>
            </div>

            {{-- Timeline --}}
            <div style="position: relative; padding-left: 16px;">
                <template x-if="!isBatal">
                    <div>
                        <template x-for="(step, index) in steps" :key="step.id">
                            <div style="position: relative; padding-bottom: 24px; padding-left: 28px;">
                                {{-- Vertical Line --}}
                                <div x-show="index !== steps.length - 1" style="position: absolute; left: 0; top: 24px; bottom: -8px; width: 2px;" :style="(steps[index+1] && isActive(steps[index+1].id)) ? 'background: var(--primary);' : 'background: #e5e7eb;'"></div>
                                
                                {{-- Circle --}}
                                <div style="position: absolute; left: -8px; top: 4px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid #fff; display: flex; align-items: center; justify-content: center;"
                                     :style="isActive(step.id) ? 'background: var(--primary);' : 'background: #d1d5db;'">
                                    <div style="width: 6px; height: 6px; border-radius: 50%; background: #fff;"></div>
                                </div>
                                
                                {{-- Content --}}
                                <div>
                                    <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0 0 4px 0;" :style="isActive(step.id) ? 'color: #111827;' : 'color: #6b7280;'">
                                        <i :class="'bi ' + step.icon" style="margin-right: 4px;"></i> <span x-text="step.label"></span>
                                    </h3>
                                    <p style="font-size: 0.85rem; color: #6b7280; margin: 0;" x-text="step.desc"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="isBatal">
                    <div>
                        {{-- Pending Step --}}
                        <div style="position: relative; padding-bottom: 24px; padding-left: 28px;">
                            <div style="position: absolute; left: 0; top: 24px; bottom: -8px; width: 2px; background: #e5e7eb;"></div>
                            <div style="position: absolute; left: -8px; top: 4px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid #fff; background: var(--primary); display: flex; align-items: center; justify-content: center;">
                                <div style="width: 6px; height: 6px; border-radius: 50%; background: #fff;"></div>
                            </div>
                            <div>
                                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0 0 4px 0; color: #111827;">
                                    <i class="bi bi-journal-check" style="margin-right: 4px;"></i> Pesanan Dibuat
                                </h3>
                                <p style="font-size: 0.85rem; color: #6b7280; margin: 0;">Menunggu konfirmasi pembayaran</p>
                            </div>
                        </div>
                        {{-- Batal Step --}}
                        <div style="position: relative; padding-bottom: 0; padding-left: 28px;">
                            <div style="position: absolute; left: -8px; top: 4px; width: 18px; height: 18px; border-radius: 50%; border: 2px solid #fff; background: #ef4444; display: flex; align-items: center; justify-content: center;">
                                <div style="width: 6px; height: 6px; border-radius: 50%; background: #fff;"></div>
                            </div>
                            <div>
                                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0 0 4px 0; color: #ef4444;">
                                    <i class="bi bi-x-circle" style="margin-right: 4px;"></i> Dibatalkan
                                </h3>
                                <p style="font-size: 0.85rem; color: #6b7280; margin: 0;">Pesanan telah dibatalkan</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Action Buttons Area --}}
            @if($orderStatus !== 'batal')
                <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #f3f4f6;">
                    @if($payStatus === 'belum_bayar')
                        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                            <a href="{{ route('pembayaran.index', $order->no_invoice) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: var(--primary); color: #fff; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='var(--primary-hover)'" onmouseout="this.style.background='var(--primary)'">
                                <i class="bi bi-credit-card"></i> Lanjut ke Pembayaran
                            </a>
                            @if($orderStatus === 'pending')
                                <div x-data="{ showCancelModal: false }">
                                    <button type="button" @click="showCancelModal = true" style="display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: #ffffff; color: #ef4444; border: 1px solid #fecaca; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#ffffff'">
                                        <i class="bi bi-x-circle"></i> Batalkan Pesanan
                                    </button>

                                    {{-- Cancel Confirmation Modal --}}
                                    <div x-show="showCancelModal" style="display: none; position: fixed; inset: 0; z-index: 50; overflow-y: auto;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                        <div style="display: flex; min-height: 100vh; align-items: center; justify-content: center; padding: 16px; text-align: center;">
                                            <div x-show="showCancelModal" x-transition.opacity style="position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); transition: opacity 0.3s;" aria-hidden="true" @click="showCancelModal = false"></div>

                                            <div x-show="showCancelModal" x-transition style="position: relative; background-color: #fff; border-radius: 12px; padding: 24px; text-align: left; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); max-width: 400px; width: 100%;">
                                                <h3 id="modal-title" style="font-size: 1.1rem; font-weight: 700; color: #111827; margin-bottom: 12px;">Konfirmasi Pembatalan</h3>
                                                <p style="font-size: 0.9rem; color: #4b5563; margin-bottom: 24px;">Apakah kamu yakin ingin membatalkan pesanan?</p>
                                                
                                                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                                                    <button type="button" @click="showCancelModal = false" style="padding: 10px 16px; background: #f3f4f6; color: #4b5563; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                                        Tutup
                                                    </button>
                                                    <form action="{{ route('order.cancel', $order->no_invoice) }}" method="POST" style="margin: 0;">
                                                        @csrf
                                                        <button type="submit" style="padding: 10px 16px; background: #ef4444; color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                                            Ya, Batalkan
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @elseif($payStatus === 'ditolak')
                        <div>
                            <a href="{{ route('pembayaran.index', $order->no_invoice) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 12px 24px; background: #ef4444; color: #fff; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                                <i class="bi bi-upload"></i> Upload Ulang Bukti
                            </a>
                        </div>
                    @endif
                </div>
            @endif

        </div>

        {{-- Order Items --}}
        <div style="background: #ffffff; border-radius: 12px; border: 1px solid #e5e7eb; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <h2 style="font-size: 1.1rem; font-weight: 700; color: #111827; margin: 0 0 16px 0; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid #f3f4f6; padding-bottom: 12px;">
                <i class="bi bi-bag" style="color: var(--primary);"></i> Item Pesanan
            </h2>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem; min-width: 500px;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 12px 8px; text-align: left; font-weight: 600; color: #374151;">Produk</th>
                            <th style="padding: 12px 8px; text-align: center; font-weight: 600; color: #374151;">Varian</th>
                            <th style="padding: 12px 8px; text-align: center; font-weight: 600; color: #374151;">Qty</th>
                            <th style="padding: 12px 8px; text-align: right; font-weight: 600; color: #374151;">Harga Satuan</th>
                            <th style="padding: 12px 8px; text-align: right; font-weight: 600; color: #374151;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            @php $detail = $item->detail_varian ?? []; @endphp
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 16px 8px; color: #111827; font-weight: 500;">
                                    {{ $detail['nama_produk'] ?? '—' }}
                                </td>
                                <td style="padding: 16px 8px; text-align: center; color: #6b7280; font-size: 0.85rem;">
                                    {{ $detail['nama_varian'] ?? '-' }}
                                </td>
                                <td style="padding: 16px 8px; text-align: center; color: #111827;">
                                    {{ $item->qty }}
                                </td>
                                <td style="padding: 16px 8px; text-align: right; color: #4b5563;">
                                    Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>
                                <td style="padding: 16px 8px; text-align: right; color: #111827; font-weight: 600;">
                                    Rp {{ number_format($item->harga_satuan * $item->qty, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="padding: 20px 8px 12px; font-weight: 700; text-align: right; color: #374151;">Total Tagihan</td>
                            <td style="padding: 20px 8px 12px; font-weight: 800; text-align: right; color: var(--primary); font-size: 1.1rem;">
                                Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </main>
</x-storefront-layout>
