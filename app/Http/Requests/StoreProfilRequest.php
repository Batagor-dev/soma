<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'poin' => 'nullable|array',
            'poin.*.icon' => 'required|string|max:50',
            'poin.*.judul' => 'required|string|max:100',
            'poin.*.deskripsi' => 'required|string|max:255',
        ];
    }
}
