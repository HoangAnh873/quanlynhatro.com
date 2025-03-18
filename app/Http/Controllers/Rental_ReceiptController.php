<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Room;
use App\Models\RentalReceipt;
use App\Models\Contract;

use Illuminate\Http\Request;

class Rental_ReceiptController extends Controller
{
    public function index($id, Request $request)
    {
        $room = Room::findOrFail($id);
    
        // Lấy ngày bắt đầu và ngày kết thúc từ URL
        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');
    
        return view('user.pages.rentals', compact('room', 'checkIn', 'checkOut'));
    }

    public function store(Request $request)
    {
        // Kiểm tra xem khách thuê đã tồn tại hay chưa
        $tenant = Tenant::firstOrCreate(
            ['phone' => $request->phone],
            [
                'full_name' => $request->full_name,
                'gender' => $request->gender ?? 'other',
                'birth_date' => $request->birth_date ?? null,
            ]
        );

        // Tạo phiếu thuê
        RentalReceipt::create([
            'room_id' => $request->room_id,
            'tenant_id' => $tenant->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'issued_date' => now(),
            'deposit' => Room::find($request->room_id)->price, // Tự động lấy giá tiền phòng làm tiền cọc
        ]);

        return redirect()->route('home')->with('success', 'Phiếu thuê đã được gửi thành công!');
    }

        // Hiển thị danh sách phiếu thuê
        public function show()
        {
            $rentalReceipts = RentalReceipt::with('tenant', 'room')
                ->where('status', 'pending')
                ->get();
    
            return view('hosts.rentals.index', compact('rentalReceipts'));
        }
    
        // Duyệt phiếu thuê
        public function approve($id)
        {
            $rental = RentalReceipt::findOrFail($id);

            // Kiểm tra lại trạng thái phòng trước khi duyệt
            // if ($rental->room->is_available === 0) {
            //     return back();
            // }

            // Cập nhật trạng thái phiếu thuê
            $rental->update(['status' => 'approved']);
        
            // Cập nhật trạng thái phòng: is_available = 0
            // $rental->room->update(['is_available' => 0]);
        
            // Tự động từ chối các phiếu thuê khác của cùng phòng
            RentalReceipt::where('room_id', $rental->room_id)
                ->where('status', 'pending')
                ->where('id', '!=', $rental->id)
                ->update(['status' => 'rejected']);

            Contract::create([
                'rental_receipt_id' => $rental->id,
                'room_id' => $rental->room_id,
                'host_id' => $rental->room->apartment->host_id, // Lấy host_id từ khu trọ
                'tenant_id' => $rental->tenant_id,
                'start_date' => $rental->start_date,
                'end_date' => $rental->end_date,
                'original_end_date' => $rental->end_date,
                'deposit' => $rental->deposit,
            ]);
        
    
            return redirect()->back()->with('success', 'Phiếu thuê đã được duyệt thành công!');
        }
    
        // Từ chối phiếu thuê
        public function reject($id)
        {
            $rental = RentalReceipt::findOrFail($id);
            $rental->update(['status' => 'rejected']);
    
            return redirect()->back()->with('error', 'Phiếu thuê đã bị từ chối!');
        }

}