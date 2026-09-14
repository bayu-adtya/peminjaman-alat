<?php

namespace App\Http\Requests\Kategori;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        $kategori = $this->route('kategori');
        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                //mengabaikan pengecekan unik untuk nama_kategori yang sama pada kategori yang sedang diperbarui
                Rule::unique('kategori', 'nama_kategori')->ignore($kategori->id),
            ],
        ];
    }
}
