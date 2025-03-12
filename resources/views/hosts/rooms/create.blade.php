@extends('adminlte::page')

@section('title', 'Thêm Phòng')

@section('content_header')
    <h1>Quản lý Phòng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Phòng Mới</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('host.rooms.store') }}" method="POST">
            @csrf

            <!-- Hiển thị khu trọ đã chọn nhưng không cho chỉnh sửa -->
            <div class="form-group">
                <label for="apartment_name">Khu Trọ</label>
                <input type="text" id="apartment_name" class="form-control" value="{{ $apartment->name }}" readonly>
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
            </div>

            <div class="form-group">
                <label for="room_number">Tên phòng</label>
                <input type="text" id="room_number" name="room_number" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="room_type_id">Loại Phòng</label>
                <select id="room_type_id" name="room_type_id" class="form-control" required onchange="updatePrice()">
                    <option value="">-- Chọn Loại Phòng --</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}" data-price="{{ $type->price }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price">Giá Thuê (VNĐ)</label>
                <input type="number" id="price" name="price" class="form-control" readonly value="0">
            </div>

            <div class="form-group">
                <label for="is_available">Trạng Thái</label>
                <select id="is_available" name="is_available" class="form-control">
                    <option value="1">Còn trống</option>
                    <option value="0">Đã thuê</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Lưu</button>
                <a href="{{ route('host.rooms.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePrice() {
        var select = document.getElementById("room_type_id");
        var priceInput = document.getElementById("price");
        var selectedOption = select.options[select.selectedIndex];
        var price = selectedOption ? selectedOption.getAttribute("data-price") : 0;
        priceInput.value = price || 0;
    }

    document.addEventListener("DOMContentLoaded", function() {
        updatePrice();
    });
</script>

@endsection
