<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fakultasList = implode(',', config('ospekrite.fakultas_list', []));

        return [
            'nama_pembeli'    => ['required', 'string', 'max:255'],
            'nim'             => ['required', 'string', 'max:50'],
            'no_whatsapp'     => ['required', 'string', 'regex:/^(\+62|08)[0-9]{8,12}$/'],
            'fakultas'        => ['required', 'string', 'in:' . $fakultasList],
            'email'           => ['nullable', 'email', 'max:255'],
            'catatan'         => ['nullable', 'string', 'max:500'],
            'payment_type'    => ['required', 'string', 'in:qris_statis'],
            'idempotency_key' => ['required', 'uuid'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_pembeli.required'    => 'Nama lengkap wajib diisi.',
            'nim.required'             => 'NIM wajib diisi.',
            'no_whatsapp.required'     => 'Nomor WhatsApp wajib diisi.',
            'no_whatsapp.regex'        => 'Format nomor WhatsApp tidak valid. Gunakan format +628xxx atau 08xxx.',
            'fakultas.required'        => 'Pilih fakultasmu.',
            'fakultas.in'             => 'Pilihan fakultas tidak valid.',
            'email.email'             => 'Format email tidak valid.',
            'catatan.max'             => 'Catatan tidak boleh lebih dari 500 karakter.',
            'payment_type.required'   => 'Pilih metode pembayaran.',
            'payment_type.in'         => 'Metode pembayaran tidak valid.',
            'idempotency_key.required' => 'Kunci idempotency diperlukan.',
            'idempotency_key.uuid'    => 'Format kunci idempotency tidak valid.',
        ];
    }
}
