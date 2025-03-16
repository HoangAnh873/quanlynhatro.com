<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Apartment;

class ContractController extends Controller
{
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
        $selectedApartment = $request->query('apartment_id', session('selected_apartment_id', $apartments->first()->id));
    
        // Nếu apartment_id không hợp lệ, lấy cái đầu tiên
        if (!$apartments->pluck('id')->contains($selectedApartment)) {
            $selectedApartment = $apartments->first()->id;
        }
    
        // Lưu lại apartment_id vào session để nhớ lần sau
        session(['selected_apartment_id' => $selectedApartment]);
    
        // Lấy khu trọ được chọn
        $selectedApartment = $apartments->where('id', $selectedApartment)->first();

        // Lấy danh sách phòng của khu trọ đã chọn
        $rooms = Room::where('apartment_id', $selectedApartment->id)->pluck('id');

        // Lấy danh sách hợp đồng của các phòng trong khu trọ
        $contracts = Contract::whereIn('room_id', $rooms)
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo mới nhất
            ->get();

        return view('hosts.contracts.index', compact('contracts', 'apartments', 'selectedApartment'));
    }

    public function getContractsByApartment($apartmentId)
    {
        $contracts = Contract::whereHas('room', function($query) use ($apartmentId) {
            $query->where('apartment_id', $apartmentId);
        })->with(['room', 'tenant'])->get();

        return response()->json($contracts);
    }

    public function cancel($id)
    {
        $contract = Contract::findOrFail($id);
    
        // Chỉ cập nhật end_date nếu hợp đồng chưa hết hạn
        if (now()->lessThan($contract->end_date)) {
            $contract->update([
                'end_date' => now(),
            ]);
        }
    
        return redirect()->back()->with('success', 'Hợp đồng đã được hủy sớm!');
    }

}
