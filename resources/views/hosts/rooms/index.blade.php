@extends('adminlte::page')

@section('title', 'Danh sách Phòng')

@section('content_header')
    <h1>Danh sách Phòng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách các phòng</h3>
        <a href="{{ route('host.rooms.create') }}" class="btn btn-success float-right"><i class="fas fa-plus"></i> Thêm phòng mới</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Số Thứ Tự</th>
                    <th>Loại Phòng</th>
                    <th>Diện Tích (m²)</th>
                    <th>Giá Thuê (VNĐ)</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->so_thu_tu }}</td>
                    <td>{{ $room->roomType->name }}</td>
                    <td>{{ $room->roomType->area }}</td>
                    <td>{{ number_format($room->roomType->price) }} VNĐ</td>
                    <td>
                        @if($room->is_rented)
                            <span class="badge badge-danger">Đã thuê</span>
                        @else
                            <span class="badge badge-success">Còn trống</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('host.rooms.edit', $room->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Sửa</a>
                        <form action="{{ route('host.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa phòng này?');">
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
@endsection
