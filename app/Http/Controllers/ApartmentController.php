<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;
use App\Models\Host;
use App\Models\Distance;
use App\Models\School;

class ApartmentController extends Controller
{
    // Danh sách khu trọ
    public function index()
    {
        // Lấy host_id từ user đang đăng nhập
        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        $apartments = Apartment::where('host_id', $host->id)->get();
        return view('hosts.apartments.index', compact('apartments'));
    }

    // Hiển thị form thêm khu trọ
    public function create()
    {
        return view('hosts.apartments.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'GPS_Latitude' => 'required|numeric', // Bắt buộc có tọa độ để tính khoảng cách
            'GPS_Longitude' => 'required|numeric',
        ]);

        // 2️⃣ Lấy thông tin chủ trọ (host_id)
        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        // 3️⃣ Tạo mới khu trọ
        $apartment = Apartment::create([
            'host_id' => $host->id,
            'name' => $request->name,
            'location' => $request->location,
            'GPS_Latitude' => $request->GPS_Latitude,
            'GPS_Longitude' => $request->GPS_Longitude,
        ]);

        // 4️⃣ Lấy danh sách tất cả các trường học
        $schools = School::all();

        // 5️⃣ Tính khoảng cách từ khu trọ mới đến từng trường học và lưu vào bảng distances
        foreach ($schools as $school) {
            $distance = Distance::calculateDistance(
                $apartment->GPS_Latitude, 
                $apartment->GPS_Longitude, 
                $school->GPS_Latitude, 
                $school->GPS_Longitude
            );

            // 6️⃣ Lưu vào bảng distances
            Distance::create([
                'apartment_id' => $apartment->id,
                'school_id' => $school->id,
                'distance' => $distance
            ]);
        }

        // 7️⃣ Chuyển hướng về danh sách khu trọ với thông báo thành công
        return redirect()->route('host.apartments.index')->with('success', 'Khu trọ đã được thêm và khoảng cách đến các trường đã được tính toán!');
    }

    // Hiển thị form chỉnh sửa khu trọ
    public function edit($id)
    {
        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        $apartment = Apartment::where('host_id', $host->id)->findOrFail($id);
        return view('hosts.apartments.edit', compact('apartment'));
    }

    // Cập nhật thông tin khu trọ
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'GPS_Latitude' => 'nullable|numeric',
            'GPS_Longitude' => 'nullable|numeric',
        ]);

        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        $apartment = Apartment::where('host_id', $host->id)->findOrFail($id);
        $apartment->update([
            'name' => $request->name,
            'location' => $request->location,
            'GPS_Latitude' => $request->GPS_Latitude,
            'GPS_Longitude' => $request->GPS_Longitude,
        ]);

        return redirect()->route('host.apartments.index')->with('success', 'Khu trọ đã được cập nhật!');
    }

    // Xóa khu trọ
    public function destroy($id)
    {
        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        $apartment = Apartment::where('host_id', $host->id)->findOrFail($id);
        $apartment->delete();

        return redirect()->route('host.apartments.index')->with('success', 'Khu trọ đã bị xóa!');
    }

    public function list(Request $request)
    {
        // Lấy danh sách khu trọ cùng với loại phòng để tối ưu truy vấn
        $apartments = Apartment::with('roomTypes')->get();

        return view('user.pages.rooms', compact('apartments'));
    }

    public function search(Request $request)
    {
        // Truy vấn danh sách khu trọ, kèm theo loại phòng
        $query = Apartment::with('roomTypes');

        // Lọc theo tên chủ trọ hoặc khu trọ
        if ($request->filled('host_name')) {
            $query->where('name', 'like', '%' . $request->host_name . '%');
        }

        // Lọc theo vị trí
        if ($request->filled('search_location')) {
            $query->where('location', 'like', '%' . $request->search_location . '%');
        }

        // Lấy danh sách khu trọ sau khi lọc
        $apartments = $query->get();

        return view('user.pages.rooms', compact('apartments'));
    }



    public function show(Apartment $apartment)
    {
        return view('user.apartments.show', compact('apartment'));
    }

    public function showRoom(Apartment $apartment)
    {
        // Ngày nhận phòng là hôm nay
        $checkIn = now()->toDateString(); 
    
        // Ngày kết thúc là 3 tháng sau
        $checkOut = now()->addMonths(3)->toDateString(); 
    
        $rooms = $apartment->rooms()->whereDoesntHave('contracts')
            ->orWhereHas('contracts', function ($query) {
                $query->where('end_date', '<', now()); // Hợp đồng đã kết thúc
            })->get();

        return view('user.pages.searchRoom', compact('rooms', 'checkIn', 'checkOut'));
    }

    public function getNearbySchools($id)
    {
        $schools = Distance::where('apartment_id', $id)
            ->join('schools', 'distances.school_id', '=', 'schools.id')
            ->orderBy('distance', 'ASC')
            ->select('schools.name', 'distances.distance')
            ->get();

        return response()->json($schools);
    }

    public function getDistance(Request $request)
    {
        $apartmentId = $request->query('apartment_id');
        $schoolName = $request->query('school_name');
    
        $school = School::where('name', 'LIKE', "%{$schoolName}%")->first();
        if (!$school) {
            return response()->json(['distance' => null]);
        }
    
        $distance = Distance::where('apartment_id', $apartmentId)
            ->where('school_id', $school->id)
            ->first();
    
        return response()->json([
            'distance' => $distance ? $distance->distance : null
        ]);
    }
}
