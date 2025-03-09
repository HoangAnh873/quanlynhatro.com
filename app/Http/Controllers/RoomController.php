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
    public function index()
    {
        $rooms = Room::with(['roomType', 'apartment'])->get();
        return view('hosts.rooms.index', compact('rooms'));
    }

    // Hiển thị form thêm phòng
    public function create()
    {
        $roomTypes = RoomType::all();
        $apartments = Apartment::all();
        return view('hosts.rooms.create', compact('roomTypes', 'apartments'));
    }

    // Lưu phòng mới vào database
    public function store(Request $request)
    {

        $user = auth()->user();
        $host = $user->host;

        $apartment = $host->apartments; // Do Host đang là hasMany với Apartment

        dd($host, $apartment);
        // if (!$apartment) {
        //     return redirect()->back()->with('error', 'Không tìm thấy khu trọ của bạn!');
        // }

        $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'is_available' => 'required|boolean',
        ]);

        // Lấy giá của loại phòng từ bảng room_types
        $roomType = RoomType::findOrFail($request->room_type_id);

        // dd($host);
        // dd($request->$user);

        Room::create([
            'apartment_id' => $apartment->id,
            'room_number' => $request->room_number,
            'room_type_id' => $request->room_type_id,
            'capacity' => $roomType->capacity,
            'price' => $roomType->price, // Giá phòng tự động lấy từ loại phòng
            'is_available' => $request->is_available,
        ]);

        return redirect()->route('host.rooms.index')->with('success', 'Thêm phòng thành công!');
    }

    // Hiển thị form chỉnh sửa phòng
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $roomTypes = RoomType::all();
        $apartments = Apartment::all();
        return view('hosts.rooms.edit', compact('room', 'roomTypes', 'apartments'));
    }

    // Cập nhật thông tin phòng
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'room_number' => 'required|unique:rooms,room_number,' . $id,
            'room_type_id' => 'required|exists:room_types,id',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        $room->update($request->all());

        return redirect()->route('host.rooms.index')->with('success', 'Cập nhật phòng thành công!');
    }

    // Xóa phòng
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('host.rooms.index')->with('success', 'Xóa phòng thành công!');
    }
}
