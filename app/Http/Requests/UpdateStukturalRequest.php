<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStukturalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'unit'      => 'required|string|max:155',
            'jabatan'   => 'required|string|max:155',
            'name'      => 'required|string|max:155',
            'photo' => 'nullable|string',
        ];
    }
}
