<?php

namespace App\Models\Setting;

use App\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory, Blameable;

    protected $table = 'app_masters';

    protected $fillable = [
        'id',
        'parent_id',
        'category',
        'name',
        'code',
        'description',
        'status',
        'order',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 't');
    }

}
