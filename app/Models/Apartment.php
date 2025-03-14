<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = ['host_id', 'name', 'image', 'description', 'location','GPS_Latitude', 'GPS_Longitude'];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Một khu trọ có nhiều loại phòng
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    // Lấy giá phòng thấp nhất trong khu trọ
    public function minPrice()
    {
        return $this->roomTypes()->min('price');
    }
}
