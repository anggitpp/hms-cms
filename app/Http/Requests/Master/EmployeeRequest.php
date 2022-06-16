<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee_number' => 'required',
            'birth_place' => 'required',
            'hotel_id' => 'required',
            'position_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'employee_number.required' => 'Kolom NIK Pegawai tidak boleh kosong',
            'birth_place.required' => 'Kolom Tempat Lahir tidak boleh kosong',
            'hotel_id.required' => 'Kolom Hotel tidak boleh kosong',
            'position_id.required' => 'Kolom Posisi tidak boleh kosong',
        ];
    }
}
