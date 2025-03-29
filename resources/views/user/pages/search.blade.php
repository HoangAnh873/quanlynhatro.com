@extends('user.layouts.master')

@section('title', 'Kết quả tìm kiếm phòng')
{{-- {{ dd($checkIn, $checkOut) }} --}}
@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Kết quả tìm kiếm phòng trọ</h2>

    @if($rooms->isEmpty())
        <div class="alert alert-warning text-center">Không có phòng nào phù hợp.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Tên phòng</th>
                        <th>Giá thuê</th>
                        <th>Số người tối đa</th>
                        <th>Khu trọ</th>
                        <th>Địa chỉ</th>
                        <th>Khoảng cách (km)</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->room_number }}</td>
                            <td><strong>{{ number_format($room->price, 0, ',', '.') }} VND</strong></td>
                            <td>{{ $room->roomType->max_occupants }}</td>
                            <td>{{ $room->apartment->name }}</td>
                            <td>{{ $room->apartment->location }}</td>
                            <td>{{ number_format($room->distance, 2) }} km</td>
                            <td>
                                <a href="{{ route('user.rentals.index', [
                                    'id' => $room->id, 
                                    'check_in' => $checkIn ? $checkIn->toDateString() : null, 
                                    'check_out' => $checkOut ? $checkOut->toDateString() : null
                                ]) }}" class="btn btn-sm btn-primary">
                                    Lập phiếu thuê
                                </a>
                                <a href="#" class="btn btn-sm btn-warning">Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại</a>
    </div>
</div>
@endsection
