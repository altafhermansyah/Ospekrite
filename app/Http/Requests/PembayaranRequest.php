<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Guest checkout — no auth required
    }

    public function rules(): array
    {
        return [
            'nama_pengirim'  => ['required', 'string', 'max:255'],
            'bukti_transfer' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp', // MIME type validation
                'max:2048',                 // 2 MB max
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pengirim.required'  => 'Nama pengirim wajib diisi.',
            'nama_pengirim.max'       => 'Nama pengirim maksimal 255 karakter.',
            'bukti_transfer.required' => 'Bukti transfer wajib diunggah.',
            'bukti_transfer.file'     => 'File tidak valid.',
            'bukti_transfer.mimes'    => 'Format bukti transfer harus: jpg, jpeg, png, atau webp.',
            'bukti_transfer.max'      => 'Ukuran file maksimal 2 MB.',
        ];
    }
}
