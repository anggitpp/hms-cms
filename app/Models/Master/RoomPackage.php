<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPackage extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_room_packages';

    protected $fillable = [
        'hotel_id',
        'name',
        'price',
        'description',
        'status'
    ];
}
