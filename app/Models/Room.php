<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['apartment_id', 'room_number', 'capacity', 'price', 'is_available'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
