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
        $apartments = Apartment::select('GPS_Latitude as latitude', 'GPS_Longitude as longitude')->get();
        
        // Lấy dữ liệu các xã ở Cần Thơ từ Overpass API
        $wards = $this->getWardsInCanTho();
        
        return view('map.index', compact('apartments', 'wards'));
    }
    
    private function getWardsInCanTho()
    {
        // Tạo URL để gọi Overpass API
        $overpassUrl = "https://overpass-api.de/api/interpreter";
        
        // Query để lấy tất cả các xã/phường ở Cần Thơ
        $query = '
            [out:json];
            area["name"="Cần Thơ"]["admin_level"="4"]->.cantho;
            rel(area.cantho)["admin_level"="9"]["boundary"="administrative"];
            out geom;
        ';
        
        // Gửi request đến Overpass API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $overpassUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        // Chuyển đổi JSON response thành mảng PHP
        $data = json_decode($response, true);
        
        // Xử lý dữ liệu để trả về dạng GeoJSON
        $wards = [];
        
        if (isset($data['elements'])) {
            foreach ($data['elements'] as $element) {
                if ($element['type'] === 'relation' && isset($element['tags']['name'])) {
                    // Chuyển đổi dữ liệu sang dạng GeoJSON
                    $geojson = $this->convertToGeoJSON($element);
                    if ($geojson) {
                        $wards[] = $geojson;
                    }
                }
            }
        }
        
        return $wards;
    }
    
    private function convertToGeoJSON($element)
    {
        // Chỉ xử lý các relation có members (thành phần của polygon)
        if (!isset($element['members']) || count($element['members']) === 0) {
            return null;
        }
        
        // Tạo polygon từ các thành phần
        $coordinates = [];
        $currentRing = [];
        
        foreach ($element['members'] as $member) {
            if ($member['type'] === 'way' && isset($member['geometry'])) {
                foreach ($member['geometry'] as $point) {
                    $currentRing[] = [$point['lon'], $point['lat']];
                }
            }
        }
        
        if (count($currentRing) > 0) {
            $coordinates[] = $currentRing;
        }
        
        if (count($coordinates) === 0) {
            return null;
        }
        
        // Tạo đối tượng GeoJSON
        return [
            'type' => 'Feature',
            'id' => $element['id'],
            'properties' => [
                'name' => $element['tags']['name'] ?? 'Không xác định'
            ],
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => $coordinates
            ]
        ];
    }
}