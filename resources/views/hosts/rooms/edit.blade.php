@extends('adminlte::page')

@section('title', 'Chỉnh Sửa Phòng')

@section('content_header')
    <h1>Quản lý Phòng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Chỉnh Sửa Thông Tin Phòng</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('host.rooms.update', $room->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="room_number">Số Thứ Tự</label>
                <input type="text" id="room_number" name="room_number" class="form-control" value="{{ $room->room_number }}" required>
            </div>

            <div class="form-group">
                <label for="room_type_id">Loại Phòng</label>
                <select id="room_type_id" name="room_type_id" class="form-control" required>
                    <option value="">-- Chọn Loại Phòng --</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" {{ $room->room_type_id == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Giá Thuê (VNĐ)</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ $room->price }}" required>
            </div>

            <div class="form-group">
                <label for="is_available">Trạng Thái</label>
                <select id="is_available" name="is_available" class="form-control">
                    <option value="1" {{ $room->is_available ? 'selected' : '' }}>Còn trống</option>
                    <option value="0" {{ !$room->is_available ? 'selected' : '' }}>Đã thuê</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Cập Nhật</button>
                <a href="{{ route('host.rooms.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
