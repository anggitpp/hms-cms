<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'type_id.required' => 'Kolom Tipe tidak boleh kosong'
        ];
    }
}
