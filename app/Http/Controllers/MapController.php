<?php

namespace App\Http\Controllers;
use App\Models\Apartment;
use Illuminate\Support\Facades\DB;
use App\Models\Host;

class MapController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu khu trọ từ cơ sở dữ liệu
        $apartments = Apartment::select('id', 'name', 'location', 'GPS_Latitude as latitude', 'GPS_Longitude as longitude')->get();

        // Đường dẫn đến file GeoJSON ranh giới hành chính
        $geoJsonPath = public_path('data/wards.geojson');
        
        // Đọc file GeoJSON
        $geoJsonContent = file_get_contents($geoJsonPath);
        $geoJson = json_decode($geoJsonContent, true);
        
        // Lấy danh sách các xã từ GeoJSON
        $wards = $geoJson['features'];
        // dd($apartments);
        return view('map.index', compact('apartments', 'wards'));
    }
    
}





