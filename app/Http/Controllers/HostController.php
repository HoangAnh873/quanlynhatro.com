<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Host;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Contract;
use App\Models\Room;
use App\Models\RentalReceipt;


class HostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = auth()->user();
        $host = $user->host;
    
        if (!$host) {
            return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
        }
    
        // Lấy số lượng khách thuê theo host
        $tenantCount = Contract::where('host_id', $host->id)->distinct('tenant_id')->count('tenant_id');
    
        // Lấy số lượng phòng của chủ trọ
        $roomCount = Room::whereIn('apartment_id', $host->apartments->pluck('id'))->count();
    
        // Số lượng phòng trống
        $emptyRoomCount = Room::whereIn('apartment_id', $host->apartments->pluck('id'))
                            ->where('is_available', 1)
                            ->count();
    
        // Số phiếu thuê đang chờ duyệt
        $pendingRentals = RentalReceipt::whereIn('room_id', Room::whereIn('apartment_id', $host->apartments->pluck('id'))->pluck('id'))
                            ->where('status', 'pending')
                            ->count();
    
        return view('hosts.dashboard', compact('tenantCount', 'roomCount', 'emptyRoomCount', 'pendingRentals'));
    }    
    

    // Hiển thị danh sách tất cả chủ trọ
    public function index()
    {
        $hosts = Host::with('user')->get();
        return view('hosts.index', compact('hosts'));
    }

    // Hiển thị form thêm chủ trọ
    public function create()
    {
        return view('hosts.create');
    }

    // Lưu chủ trọ mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'   => 'required|string|max:15|unique:hosts,phone',
            'address' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'host',
        ]);

        Host::create([
            'user_id' => $user->id, // Gán đúng user_id
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('hosts.index')->with('success', 'Thêm chủ trọ thành công!');
    }

    // Hiển thị form chỉnh sửa chủ trọ
    public function edit($id)
    {
        $host = Host::with('user')->findOrFail($id);
        return view('hosts.edit', compact('host'));
    }

    // Cập nhật thông tin chủ trọ
    public function update(Request $request, $id)
    {
        $host = Host::with('user')->findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $host->user_id,
            'phone'   => 'required|string|max:15|unique:hosts,phone,' . $id,
            'address' => 'required|string|max:255',
        ]);

        $host->update([
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $host->user->update([
            'name' => $request->full_name, // Đồng bộ hóa họ tên
            'email' => $request->email,
        ]);

        return redirect()->route('hosts.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    // Xóa chủ trọ (kèm user liên quan)
    public function destroy($id)
    {
        $host = Host::findOrFail($id);

        // Xóa user liên kết
        if ($host->user) {
            $host->user->delete();
        }

        $host->delete();

        return redirect()->route('hosts.index')->with('success', 'Xóa thành công!');
    }
}
