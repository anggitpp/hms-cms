<?php

namespace App\Models\Transaction;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelOrder extends Model
{
    use HasFactory, Blameable;

    protected $table = 'transaction_hotel_orders';

    protected $fillable = [
        'hotel_id',
        'name',
        'identity_number',
        'address',
        'province_id',
        'city_id',
        'postal_code',
        'email',
        'phone_number',
        'company_name',
        'arrival_date',
        'departure_date',
        'number_of_nights',
        'number_of_adults',
        'package_id',
        'package_price',
        'package_total',
        'rooms',
        'extra_bed',
        'extra_bed_price',
        'price',
        'discount',
        'discount_price',
        'fix_price',
        'note',
        'payment_method',
        'payment_detail',
        'status',
        'company_emergency_name',
        'company_phone',
        'company_accomodation',
        'nationality_id',
        'folio_number'
    ];
}
