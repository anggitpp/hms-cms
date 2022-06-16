<?php

namespace App\Models\Master;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, Blameable;

    protected $table = 'master_rooms';

    protected $fillable = [
        'number',
        'type_id',
        'hotel_id',
        'description',
        'status_id',
        'inactive_reason'
    ];
}
