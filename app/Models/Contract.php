<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_receipt_id',
        'room_id',
        'host_id',
        'tenant_id',
        'start_date',
        'end_date',
        'original_end_date',
        'deposit',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function rentalReceipt()
    {
        return $this->belongsTo(RentalReceipt::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

}

