<x-storefront-layout title="Cek Pesanan | Ospekrite">
    <main class="layout-container" style="padding: 60px 20px; max-width: 500px; margin: 0 auto; font-family: 'Inter', sans-serif;">
        
        <div style="background: #ffffff; border-radius: 16px; padding: 32px 28px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;">
            <div style="text-align: center; margin-bottom: 24px;">
                <div style="display: inline-flex; justify-content: center; align-items: center; width: 64px; height: 64px; background: #eff6ff; color: var(--primary); border-radius: 50%; margin-bottom: 16px;">
                    <i class="bi bi-search" style="font-size: 1.8rem;"></i>
                </div>
                <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0 0 8px 0;">Lacak Pesanan</h1>
                <p style="font-size: 0.9rem; color: #6b7280; margin: 0;">
                    Masukkan detail pesanan Anda untuk melihat status dan rinciannya dengan aman.
                </p>
            </div>

            @if(session('error'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; display: flex; gap: 8px; align-items: flex-start;">
                    <i class="bi bi-exclamation-triangle-fill" style="margin-top: 2px;"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->has('not_found'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; display: flex; gap: 8px; align-items: flex-start;">
                    <i class="bi bi-shield-lock-fill" style="margin-top: 2px;"></i>
                    <span>{{ $errors->first('not_found') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('track.cari') }}">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label for="no_invoice" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        No. Invoice
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <input type="text" 
                               id="no_invoice" 
                               name="no_invoice" 
                               value="{{ old('no_invoice') }}"
                               placeholder="Contoh: OSP-2026-000001"
                               style="width: 100%; padding: 12px 14px 12px 40px; border: 1px solid {{ $errors->has('no_invoice') ? '#ef4444' : '#d1d5db' }}; border-radius: 8px; font-family: 'Courier New', Courier, monospace; font-size: 0.95rem; font-weight: 600; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(37, 99, 235, 0.1)'"
                               onblur="this.style.borderColor='{{ $errors->has('no_invoice') ? '#ef4444' : '#d1d5db' }}'; this.style.boxShadow='none'"
                               required>
                    </div>
                    @error('no_invoice')
                        <div style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="no_whatsapp" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 8px;">
                        Nomor WhatsApp
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af;">
                            <i class="bi bi-whatsapp"></i>
                        </span>
                        <input type="tel" 
                               id="no_whatsapp" 
                               name="no_whatsapp" 
                               value="{{ old('no_whatsapp') }}"
                               placeholder="Contoh: 08123456789"
                               style="width: 100%; padding: 12px 14px 12px 40px; border: 1px solid {{ $errors->has('no_whatsapp') ? '#ef4444' : '#d1d5db' }}; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.95rem; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(37, 99, 235, 0.1)'"
                               onblur="this.style.borderColor='{{ $errors->has('no_whatsapp') ? '#ef4444' : '#d1d5db' }}'; this.style.boxShadow='none'"
                               required>
                    </div>
                    @error('no_whatsapp')
                        <div style="color: #dc2626; font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" 
                        style="width: 100%; padding: 14px; background: var(--primary); color: #ffffff; border: none; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: background 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;"
                        onmouseover="this.style.background='var(--primary-hover)'"
                        onmouseout="this.style.background='var(--primary)'">
                    <span>Cek Pesanan</span>
                    <i class="bi bi-arrow-right-short" style="font-size: 1.2rem;"></i>
                </button>
            </form>

            <div style="text-align: center; margin-top: 20px;">
                <p style="font-size: 0.75rem; color: #9ca3af; margin: 0; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <i class="bi bi-lock-fill"></i> Data pesanan Anda dilindungi
                </p>
            </div>
        </div>

    </main>
</x-storefront-layout>
