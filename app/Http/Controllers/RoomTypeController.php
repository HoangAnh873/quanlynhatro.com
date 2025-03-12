<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    // Hiển thị danh sách loại phòng
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
    
        // Lấy danh sách loại phòng của khu trọ đã chọn
        $typeRooms = RoomType::where('apartment_id', $selectedApartment->id)
                     ->with('apartment')
                     ->get();
        // dd($typeRooms->toArray());
        // dd($typeRooms);
        return view('hosts.RoomType.index', compact('typeRooms', 'apartments', 'selectedApartment'));
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
            return redirect()->route('host.types.index')->with('error', 'Bạn chưa có khu trọ nào, hãy tạo khu trọ trước.');
        }
    
        // Lấy apartment_id từ request hoặc mặc định là khu trọ đầu tiên
        $apartmentId = $request->query('apartment_id', session('selected_apartment_id', $apartments->first()->id));
        $apartment = $apartments->firstWhere('id', $apartmentId);
    
        // Nếu không tìm thấy khu trọ hợp lệ, đặt lại thành khu trọ đầu tiên
        if (!$apartment) {
            return redirect()->route('host.types.index')->with('error', 'Không tìm thấy khu trọ hợp lệ.');
        }
    
        return view('hosts.RoomType.create', compact('apartment'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'name' => 'required|string|max:255',
            'max_occupants' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        RoomType::create([
            'apartment_id' => $request->apartment_id,
            'name' => $request->name,
            'max_occupants' => $request->max_occupants,
            'area' => $request->area,
            'price' => $request->price,
        ]);

        return redirect()->route('host.types.index', ['apartment_id' => $request->apartment_id])
            ->with('success', 'Thêm loại phòng thành công!');
    }


    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('hosts.RoomType.edit', compact('roomType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_occupants' => 'required|integer|min:1',
            'area' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $roomType = RoomType::findOrFail($id);
        $roomType->update($request->all());

        return redirect()->route('host.types.index')->with('success', 'Room type updated successfully!');
    }

    public function destroy($id)
    {
        RoomType::destroy($id);
        return redirect()->route('host.types.index')->with('success', 'Room type deleted successfully!');
    }
}

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\RoomType;
// use App\Models\Apartment;

// class RoomTypeController extends Controller
// {
//     public function index(Request $request)
//     {
//         $user = auth()->user();
//         $host = $user->host;

//         if (!$host) {
//             return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
//         }

//         // Lấy danh sách khu trọ của chủ trọ đang đăng nhập
//         $apartments = Apartment::where('host_id', $host->id)->get();

//         if ($apartments->isEmpty()) {
//             return redirect()->back()->with('error', 'Bạn chưa có khu trọ nào.');
//         }

//         // Mặc định chọn khu trọ đầu tiên nếu chưa có chọn trước đó
//         $selectedApartment = $apartments->first();

//         if ($request->has('apartment_id')) {
//             $selectedApartment = $apartments->where('id', $request->apartment_id)->first();
//         }

//         if (!$selectedApartment) {
//             return redirect()->back()->with('error', 'Khu trọ không hợp lệ.');
//         }

//         // Lấy danh sách loại phòng theo khu trọ đang chọn
//         $roomTypes = RoomType::where('apartment_id', $selectedApartment->id)->get();

//         return view('hosts.RoomType.index', compact('apartments', 'selectedApartment', 'roomTypes'));
//     }

//     public function create(Request $request)
//     {
//         $user = auth()->user();
//         $host = $user->host;

//         if (!$host) {
//             return redirect()->back()->with('error', 'Không tìm thấy tài khoản chủ trọ.');
//         }

//         $apartments = Apartment::where('host_id', $host->id)->get();

//         if ($apartments->isEmpty()) {
//             return redirect()->back()->with('error', 'Bạn chưa có khu trọ nào.');
//         }

//         $selectedApartment = $apartments->first();

//         if ($request->has('apartment_id')) {
//             $selectedApartment = $apartments->where('id', $request->apartment_id)->first();
//         }

//         if (!$selectedApartment) {
//             return redirect()->back()->with('error', 'Khu trọ không hợp lệ.');
//         }

//         return view('hosts.RoomType.create', compact('selectedApartment'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'apartment_id' => 'required|exists:apartments,id',
//             'name' => 'required|string|max:255',
//             'max_occupants' => 'required|integer|min:1',
//             'area' => 'required|numeric|min:0',
//             'price' => 'required|numeric|min:0',
//         ]);

//         RoomType::create([
//             'apartment_id' => $request->apartment_id,
//             'name' => $request->name,
//             'max_occupants' => $request->max_occupants,
//             'area' => $request->area,
//             'price' => $request->price,
//         ]);

//         return redirect()->route('host.types.index', ['apartment_id' => $request->apartment_id])
//             ->with('success', 'Thêm loại phòng thành công!');
//     }

//     public function edit($id)
//     {
//         $roomType = RoomType::findOrFail($id);

//         return view('hosts.RoomType.edit', compact('roomType'));
//     }

//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'max_occupants' => 'required|integer|min:1',
//             'area' => 'required|numeric|min:0',
//             'price' => 'required|numeric|min:0',
//         ]);

//         $roomType = RoomType::findOrFail($id);
//         $roomType->update($request->all());

//         return redirect()->route('host.types.index', ['apartment_id' => $roomType->apartment_id])
//             ->with('success', 'Cập nhật loại phòng thành công!');
//     }

//     public function destroy($id)
//     {
//         $roomType = RoomType::findOrFail($id);
//         $apartment_id = $roomType->apartment_id;
//         $roomType->delete();

//         return redirect()->route('host.types.index', ['apartment_id' => $apartment_id])
//             ->with('success', 'Xóa loại phòng thành công!');
//     }
// }
