<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomPrice extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_room_prices';

    protected $fillable = [
        'hotel_id',
        'type_id',
        'price',
        'description'
    ];
}
