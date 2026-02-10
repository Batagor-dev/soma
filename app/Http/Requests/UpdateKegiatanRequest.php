<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKegiatanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'title'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'waktu'     => 'nullable|date',
        ];
    }
}
