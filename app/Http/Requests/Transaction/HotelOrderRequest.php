<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class HotelOrderRequest extends FormRequest
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
            'identity_number' => 'required',
            'phone_number' => 'required',
            'arrival_date' => 'required',
            'departure_date' => 'required',
            'rooms' => 'required',
            'number_of_adults' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong',
            'identity_number.required' => 'Kolom Nomor Identitas tidak boleh kosong',
            'phone_number.required' => 'Kolom Nomor Handphone tidak boleh kosong',
            'arrival_date.required' => 'Kolom Tanggal Masuk tidak boleh kosong',
            'departure_date.required' => 'Kolom Tanggal Keluar tidak boleh kosong',
            'rooms.required' => 'Kolom Kamar tidak boleh kosong',
            'number_of_adults.required' => 'Kolom Jumlah Orang Dewasa tidak boleh kosong',
        ];
    }
}
