<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Apartment;

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
}