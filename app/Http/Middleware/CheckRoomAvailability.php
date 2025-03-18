<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class CheckRoomAvailability
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Lấy danh sách tất cả các phòng
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Kiểm tra xem phòng này có hợp đồng đang hoạt động hay không
            $isOccupied = DB::table('contracts')
                ->where('room_id', $room->id)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->exists();

            // Nếu phòng đang có hợp đồng, rán is_available = 0, ngược lại = 1
            $room->update(['is_available' => $isOccupied ? 0 : 1]);
        }

        return $next($request);
    }
}
