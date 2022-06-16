<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAdditional extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_room_additionals';

    protected $fillable = [
        'hotel_id',
        'name',
        'price',
        'description',
        'status',
    ];
}
