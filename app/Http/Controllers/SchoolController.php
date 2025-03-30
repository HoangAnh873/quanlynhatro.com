<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\Distance;
use App\Models\Apartment;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Xác thực dữ liệu đầu vào
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'GPS_Latitude' => 'required|numeric', // Bắt buộc có tọa độ để tính khoảng cách
            'GPS_Longitude' => 'required|numeric',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        // 2️⃣ Xử lý upload icon nếu có
        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->file('icon')->getClientOriginalExtension();
            $request->file('icon')->move(public_path('img/icons'), $iconName);
            $data['icon'] = $iconName;
        }

        // 3️⃣ Tạo mới trường học
        $school = School::create($data);

        // 4️⃣ Lấy danh sách tất cả các khu trọ hiện có
        $apartments = Apartment::all();

        // 5️⃣ Tính khoảng cách từ trường học mới đến từng khu trọ và lưu vào bảng distances
        foreach ($apartments as $apartment) {
            $distance = Distance::calculateDistance(
                $school->GPS_Latitude, 
                $school->GPS_Longitude, 
                $apartment->GPS_Latitude, 
                $apartment->GPS_Longitude
            );

            // 6️⃣ Lưu vào bảng distances
            Distance::create([
                'apartment_id' => $apartment->id,
                'school_id' => $school->id,
                'distance' => $distance
            ]);
        }

        // 7️⃣ Chuyển hướng về danh sách trường học với thông báo thành công
        return redirect()->route('schools.index')->with('success', 'Thêm trường học thành công và khoảng cách đã được tính toán!');
    }

    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'GPS_Latitude' => 'nullable|numeric',
            'GPS_Longitude' => 'nullable|numeric',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);
    
        $school = School::findOrFail($id);
    
        // Nếu có icon mới thì cập nhật
        if ($request->hasFile('icon')) {
            $iconName = time() . '.' . $request->icon->extension();
            $request->icon->move(public_path('img/icons'), $iconName);
            $data['icon'] = $iconName;
        } else {
            // Giữ nguyên icon cũ
            $data['icon'] = $school->icon;
        }
    
        $school->update($data);
    
        return redirect()->route('schools.index')->with('success', 'Cập nhật trường học thành công!');
    }
    
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'Xóa trường học thành công!');
    }

    public function getNearbyApartments($id)
    {
        $apartments = Distance::where('school_id', $id)
            ->join('apartments', 'distances.apartment_id', '=', 'apartments.id')
            ->orderBy('distance', 'ASC')
            ->select('apartments.name', 'distances.distance')
            ->get();

        return response()->json($apartments);
    }

    public function showDistances()
    {
        $distances = Distance::join('schools', 'distances.school_id', '=', 'schools.id')
            ->join('apartments', 'distances.apartment_id', '=', 'apartments.id')
            ->select('schools.name as school_name', 'apartments.name as apartment_name', 'distances.distance')
            ->orderBy('distances.distance', 'ASC')
            ->get();

        $schools = School::all(); // Lấy danh sách tất cả trường học

        return view('distances.index', compact('distances', 'schools'));
    }

    public function search(Request $request)
    {
        // Lấy tên trường từ input tìm kiếm
        $schoolName = $request->input('search_location');
        $radius = $request->input('radius');

        // Tìm trường học theo tên
        $school = School::where('name', 'like', '%' . $schoolName . '%')->first();

        if (!$school) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy trường học.']);
        }

        // Lấy danh sách apartment_id từ bảng distances với distance <= radius
        $apartments = Distance::where('school_id', $school->id)
                            ->where('distance', '<=', $radius)
                            ->pluck('apartment_id');

        // Lấy thông tin chi tiết của các khu trọ
        $apartmentDetails = Apartment::whereIn('id', $apartments)->get();

        return response()->json([
            'status' => 'success',
            'apartments' => $apartmentDetails,
            'school' => $school
        ]);
    }
}
