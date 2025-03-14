<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'start_date',
        'end_date',
        'issued_date',
        'deposit',
        'status'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
