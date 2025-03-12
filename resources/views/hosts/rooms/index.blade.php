@extends('adminlte::page')

@section('title', 'Danh sách Phòng')

@section('content_header')
    <h1>Quản lý Phòng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách phòng</h3>
        <a href="{{ route('host.rooms.create', ['apartment_id' => $selectedApartment->id]) }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Thêm phòng mới</a>
    </div>
    <div class="card-body">
        <!-- Chọn khu trọ -->
        <form method="GET" id="apartmentForm">
            <label for="apartmentSelect">Chọn khu trọ:</label>
            <select name="apartment_id" id="apartmentSelect" class="form-control">
                @foreach($apartments as $apartment)
                    <option value="{{ $apartment->id }}" {{ $apartment->id == $selectedApartment->id ? 'selected' : '' }}>
                        {{ $apartment->name }}
                    </option>
                @endforeach
            </select>
        </form>
        
        <script>
        document.getElementById('apartmentSelect').addEventListener('change', function() {
            document.getElementById('apartmentForm').submit(); // Tự động gửi form khi chọn khu trọ
        });
        </script>

        <!-- Bảng danh sách phòng -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên phòng</th>
                    <th>Loại Phòng</th>
                    <th>Diện Tích</th>
                    <th>Giá Thuê</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="room-list">
                @foreach ($rooms as $room)
                <tr>
                    <td>{{ $room->room_number }}</td>
                    <td>{{ optional($room->roomType)->name ?? 'Không xác định' }}</td>
                    <td>{{ $room->capacity }}  (m²)</td>
                    <td>{{ number_format($room->price, 0, ',', '.') }} VND</td>
                    <td>{{ $room->is_available ? 'Còn phòng' : 'Hết phòng' }}</td>
                    <td>
                        <a href="{{ route('host.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('host.rooms.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script AJAX để lấy danh sách phòng theo khu trọ -->
@section('js')
<script>
    document.getElementById('apartment_id').addEventListener('change', function() {
        let apartmentId = this.value;
        let roomList = document.getElementById('room-list');

        if (!apartmentId) {
            roomList.innerHTML = "<tr><td colspan='7' class='text-center'>Vui lòng chọn khu trọ</td></tr>";
            return;
        }

        fetch(`/host/rooms/by-apartment/${apartmentId}`)
            .then(response => response.json())
            .then(data => {
                let html = "";
                if (data.length > 0) {
                    data.forEach(room => {
                        html += `
                            <tr>
                                <td>${room.id}</td>
                                <td>${room.so_thu_tu}</td>
                                <td>${room.room_type.name}</td>
                                <td>${room.room_type.area}</td>
                                <td>${new Intl.NumberFormat().format(room.room_type.price)} VNĐ</td>
                                <td>
                                    ${room.is_rented ? '<span class="badge badge-danger">Đã thuê</span>' : '<span class="badge badge-success">Còn trống</span>'}
                                </td>
                                <td>
                                    <a href="/host/rooms/${room.id}/edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                                    <form action="/host/rooms/${room.id}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa phòng này?');">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = "<tr><td colspan='7' class='text-center'>Không có phòng nào trong khu trọ này</td></tr>";
                }
                roomList.innerHTML = html;
            })
            .catch(error => console.error('Lỗi:', error));
    });
</script>
@endsection
@endsection
