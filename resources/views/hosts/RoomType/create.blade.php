@extends('adminlte::page')

@section('title', 'Thêm Loại Phòng')

@section('content_header')
    <h1>Quản lý Loại Phòng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nhập Thông Tin Loại Phòng</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('host.types.store') }}" method="POST">
            @csrf
            
            <!-- Hiển thị khu trọ đã chọn nhưng không cho chỉnh sửa -->
            <div class="form-group">
                <label for="apartment_name">Khu Trọ</label>
                <input type="text" id="apartment_name" class="form-control" value="{{ $apartment->name }}" readonly>
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
            </div>

            <div class="form-group">
                <label for="name">Tên Loại Phòng</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="max_occupants">Số Người Tối Đa</label>
                <input type="number" id="max_occupants" name="max_occupants" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="area">Diện Tích (m²)</label>
                <input type="number" step="0.1" id="area" name="area" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Giá Thuê (VNĐ)</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Lưu</button>
                <a href="{{ route('host.types.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
