<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_hotels';

    protected $fillable = [
        'name',
        'code',
        'type_id',
        'address',
        'province_id',
        'city_id',
        'postal_code',
        'phone_number',
        'email',
        'photo',
        'latitude',
        'longitude',
        'description',
        'status'
    ];
}
