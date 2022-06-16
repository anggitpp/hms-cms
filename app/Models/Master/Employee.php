<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_employees';

    protected $fillable = [
        'hotel_id',
        'name',
        'employee_number',
        'position_id',
        'birth_date',
        'birth_place',
        'gender',
        'phone_number',
        'religion_id',
        'photo',
        'status'
    ];
}
