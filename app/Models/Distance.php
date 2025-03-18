<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Distance extends Model
{
    protected $fillable = ['apartment_id', 'school_id', 'distance'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }


    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $apiKey = "pk.eyJ1IjoiaG9hbmdhbmhoaCIsImEiOiJjbTg2NXlxbXYwMWRzMmpxeHZxODJ0b2Q1In0.37CjmObFMH_1B04-QE6MtQ"; // Thay bằng API Key của bạn
    $url = "https://api.mapbox.com/directions/v5/mapbox/driving/{$lon1},{$lat1};{$lon2},{$lat2}"
         . "?access_token={$apiKey}&geometries=geojson";

    $response = Http::get($url);
    $data = $response->json();

    if (!empty($data['routes'][0]['distance'])) {
        return $data['routes'][0]['distance'] / 1000; // Convert meters to km
        
    }
    return null; // Nếu không có dữ liệu
}
}