<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_types';
    
    protected $fillable = [
        'apartment_id',
        'name',
        'max_occupants',
        'area',
        'price',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
