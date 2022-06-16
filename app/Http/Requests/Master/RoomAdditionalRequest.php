<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class RoomAdditionalRequest extends FormRequest
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
            'price' => 'required|not_in:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'price.required' => 'Kolom Harga tidak boleh kosong',
            'price.not_in' => 'Kolom Harga tidak boleh 0',
        ];
    }
}
