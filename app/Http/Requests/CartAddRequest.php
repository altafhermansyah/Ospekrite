<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartAddRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipe' => ['required', 'string', 'in:produk,bundle'],
            'id_ref' => ['required', 'integer', 'min:1'],
            'qty' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
