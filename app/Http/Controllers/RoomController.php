<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Apartment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    // Hiển thị danh sách phòng
    public function index(Request $request)
    {
        $user = auth()->user();
        $host = $user->host;
    
        if (!$host) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
        }
    
        // Lấy danh sách khu trọ của chủ trọ
        $apartments = $host->apartments;
    
        if ($apartments->isEmpty()) {
            return redirect()->back()->with('error', 'Bạn chưa có khu trọ nào, hãy tạo khu trọ trước.');
        }
    
        // Lấy apartment_id từ URL hoặc Session (nếu đã chọn trước đó)
        $selectedApartmentId = $request->query('apartment_id', session('selected_apartment_id', $apartments->first()->id));
    
        // Nếu apartment_id không hợp lệ, lấy cái đầu tiên
        if (!$apartments->pluck('id')->contains($selectedApartmentId)) {
            $selectedApartmentId = $apartments->first()->id;
        }
    
        // Lưu lại apartment_id vào session để nhớ lần sau
        session(['selected_apartment_id' => $selectedApartmentId]);
    
        // Lấy khu trọ được chọn
        $selectedApartment = $apartments->where('id', $selectedApartmentId)->first();
    
        // Lấy danh sách phòng của khu trọ đã chọn
        $rooms = Room::where('apartment_id', $selectedApartment->id)
                     ->with(['roomType', 'apartment'])
                     ->get();
        // dd($rooms->toArray());
        return view('hosts.rooms.index', compact('rooms', 'apartments', 'selectedApartment'));
    }    

    // Hiển thị form thêm phòng
    public function create(Request $request)
    {
        $user = auth()->user();
        $host = $user->host;
    
        if (!$host) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
        }
    
        // Lấy danh sách khu trọ của chủ trọ
        $apartments = $host->apartments;
    
        if ($apartments->isEmpty()) {
            return redirect()->route('host.apartments.create')->with('error', 'Bạn chưa có khu trọ nào, hãy tạo khu trọ trước.');
        }
    
        // Lấy apartment_id từ request hoặc mặc định là khu trọ đầu tiên
        $apartmentId = $request->query('apartment_id', $apartments->first()->id);
        $apartment = $apartments->firstWhere('id', $apartmentId);
    
        // Nếu không tìm thấy khu trọ hợp lệ, đặt lại thành khu trọ đầu tiên
        if (!$apartment) {
            return redirect()->route('host.rooms.index')->with('error', 'Không tìm thấy khu trọ hợp lệ.');
        }
    
        // Lấy danh sách loại phòng
        $roomTypes = RoomType::where('apartment_id', $apartment->id)->get();
    
        return view('hosts.rooms.create', compact('roomTypes', 'apartment'));
    }    
    
    

    // Lưu phòng mới vào database
    public function store(Request $request)
    {
        $user = auth()->user();
        $host = $user->host;
    
        if (!$host) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
        }
    
        // Xác thực dữ liệu đầu vào
        $validatedData = $request->validate([
            'room_number'   => 'required|string',
            'apartment_id'  => 'required|exists:apartments,id',
            'room_type_id'  => 'required|exists:room_types,id',
            'is_available'  => 'required|in:0,1', // Thay thế boolean để tránh lỗi
        ]);
    
        // Kiểm tra xem khu trọ có thuộc về chủ trọ hay không
        $apartment = Apartment::where('id', $validatedData['apartment_id'])
                              ->where('host_id', $host->id)
                              ->first();
    
        if (!$apartment) {
            return redirect()->back()->with('error', 'Không tìm thấy khu trọ của bạn.');
        }
    
        // Kiểm tra loại phòng có tồn tại không
        $roomType = RoomType::find($validatedData['room_type_id']);
        if (!$roomType) {
            return redirect()->back()->with('error', 'Loại phòng không hợp lệ.');
        }
    
        // Kiểm tra số phòng có bị trùng trong cùng khu trọ không
        $existingRoom = Room::where('apartment_id', $apartment->id)
                            ->where('room_number', $validatedData['room_number'])
                            ->exists();
    
        if ($existingRoom) {
            return redirect()->back()->with('error', 'Số phòng này đã tồn tại trong khu trọ.');
        }
    
        // Tạo phòng mới
        Room::create([
            'apartment_id' => $apartment->id,
            'room_number'  => $validatedData['room_number'],
            'room_type_id' => $roomType->id,
            'capacity'     => $roomType->area ?? 1,
            'price'        => $roomType->price,
            'is_available' => $validatedData['is_available'],
        ]);
    
        return redirect()->route('host.rooms.index', ['apartment_id' => $apartment->id])
                         ->with('success', 'Thêm phòng thành công!');
    }
    
    

    // Hiển thị form chỉnh sửa phòng
    public function edit($id)
    {
        $user = auth()->user();
        $host = $user->host;
    
        $room = Room::findOrFail($id);
    
        if ($room->apartment->host_id !== $host->id) {
            return redirect()->route('host.rooms.index')->with('error', 'Bạn không có quyền chỉnh sửa phòng này.');
        }
    
        $roomTypes = RoomType::all();
        $apartments = $host->apartments;
        $apartment = $room->apartment; // Lấy khu trọ của phòng này
    
        return view('hosts.rooms.edit', compact('room', 'roomTypes', 'apartments', 'apartment'));
    }    

    // Cập nhật thông tin phòng
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $host = $user->host;
    
        $room = Room::findOrFail($id);
    
        if ($room->apartment->host_id !== $host->id) {
            return redirect()->route('host.rooms.index')->with('error', 'Bạn không có quyền cập nhật phòng này.');
        }
    
        $request->validate([
            'room_number' => 'required|string|unique:rooms,room_number,' . $id . ',id,apartment_id,' . $room->apartment_id,
            'room_type_id' => 'required|exists:room_types,id',
            'is_available' => 'required|boolean',
        ]);
    
        // Kiểm tra loại phòng có tồn tại không
        $roomType = RoomType::find($request->room_type_id);
        if (!$roomType) {
            return redirect()->back()->with('error', 'Loại phòng không hợp lệ.');
        }
    
        $room->update([
            'room_number' => $request->room_number,
            'room_type_id' => $roomType->id,
            'capacity' => $roomType->area ?? 1,
            'price' => $roomType->price,
            'is_available' => $request->is_available,
        ]);
    
        return redirect()->route('host.rooms.index', ['apartment_id' => $room->apartment_id])->with('success', 'Cập nhật phòng thành công!');
    }

    // Xóa phòng
    public function destroy($id)
    {
        $user = auth()->user();
        $host = $user->host;

        $room = Room::findOrFail($id);

        // Kiểm tra quyền sở hữu
        if ($room->apartment->host_id !== $host->id) {
            return redirect()->route('host.rooms.index')->with('error', 'Bạn không có quyền xóa phòng này.');
        }

        $room->delete();

        return redirect()->route('host.rooms.index')->with('success', 'Xóa phòng thành công!');
    }
    
    public function search(Request $request)
    {
        $query = Room::query();
    
        // Lọc theo số người tối đa
        if ($request->filled('num_people')) {
            $numPeople = intval($request->num_people);
            $query->whereHas('roomType', function ($q) use ($numPeople) {
                $q->where('max_occupants', '>=', $numPeople);
            });
        }
    
        // Lọc theo giá phòng
        if ($request->filled('price')) {
            $price = intval($request->price);
            if ($price > 2000000) {
                $query->where('price', '>', 2000000);
            } else {
                $query->where('price', '<=', $price);
            }
        }
    
        // Lọc theo ngày nhận phòng và tính ngày kết thúc
        $checkIn = null;
        $checkOut = null;
    
        if ($request->filled('check_in_date') && $request->filled('duration')) {
            try {
                $checkIn = Carbon::parse($request->check_in_date);
                $duration = intval($request->duration); // Số tháng thuê
                $checkOut = $checkIn->copy()->addMonths($duration);
    
                $query->whereDoesntHave('contracts', function ($q) use ($checkIn, $checkOut) {
                    $q->where('end_date', '>=', $checkIn)
                      ->where('start_date', '<=', $checkOut);
                });
    
            } catch (\Exception $e) {
                return back()->with('error', 'Ngày không hợp lệ!');
            }
        }
    
        // Lấy danh sách phòng hợp lệ
        $rooms = $query->with(['apartment'])->get();

        // Lọc theo bán kính nếu có tọa độ
        if ($request->filled('latitude') && $request->filled('longitude') && $request->filled('radius')) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $radius = $request->radius;

            // Tính khoảng cách cho từng phòng
            foreach ($rooms as $room) {
                if ($room->apartment) {
                    $room->distance = $this->calculateDistance(
                        $latitude, $longitude,
                        $room->apartment->GPS_Latitude,
                        $room->apartment->GPS_Longitude
                    );
                } else {
                    $room->distance = null;
                }
            }

            // Lọc các phòng trong bán kính
            $rooms = $rooms->filter(function ($room) use ($radius) {
                return $room->distance !== null && $room->distance <= $radius;
            });

            // Sắp xếp theo khoảng cách tăng dần
            $rooms = $rooms->sortBy('distance');
        }
        // dd($checkIn, $checkOut);
        return view('user.pages.search', compact('rooms', 'checkIn', 'checkOut'));
    }

    // Hàm tính khoảng cách theo công thức Haversine
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Bán kính Trái Đất (km)

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Khoảng cách (km)
    }

}