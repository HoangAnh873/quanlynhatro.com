<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Auth;
use App\Models\Host;

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

    // Lưu khu trọ mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'GPS_Latitude' => 'nullable|numeric',
            'GPS_Longitude' => 'nullable|numeric',
        ]);

        // Lấy host_id
        $host = Host::where('user_id', Auth::id())->first();
        if (!$host) {
            return back()->withErrors(['error' => 'Không tìm thấy tài khoản chủ trọ.']);
        }

        Apartment::create([
            'host_id' => $host->id,
            'name' => $request->name,
            'location' => $request->location,
            'GPS_Latitude' => $request->GPS_Latitude,
            'GPS_Longitude' => $request->GPS_Longitude,
        ]);

        return redirect()->route('host.apartments.index')->with('success', 'Khu trọ đã được thêm!');
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
}
