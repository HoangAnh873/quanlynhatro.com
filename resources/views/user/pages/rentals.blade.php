@extends('user.layouts.master')

@section('title', 'lập phiếu thuê')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">Lập Phiếu Thuê Phòng</h2>
    <form action="{{ route('user.rentals.store') }}" method="POST" class="bg-white p-5 rounded-4 shadow-lg">
        @csrf
        
        <input type="hidden" name="room_id" value="{{ $room->id }}">

        <div class="mb-4">
            <label for="full_name" class="form-label fw-bold">Họ và tên</label>
            <input type="text" name="full_name" class="form-control" placeholder="Nhập họ và tên" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="mb-4">
            <label for="gender" class="form-label fw-bold"></label>
            <select name="gender" class="form-select">
                <option value="">chọn giới tính</option>
                <option value="male">Nam</option>
                <option value="female">Nữ</option>
                <option value="other">Khác</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <label for="start_date" class="form-label fw-bold">Ngày bắt đầu</label>
                <input type="date" name="start_date" id="start_date" class="form-control bg-light" value="{{ $checkIn }}" readonly>
            </div>
            <div class="col-md-6 mb-4">
                <label for="end_date" class="form-label fw-bold">Ngày kết thúc</label>
                <input type="date" name="end_date" id="end_date" class="form-control bg-light" value="{{ $checkOut }}" readonly>
            </div>
        </div>

        <div class="mb-4">
            <label for="issued_date" class="form-label fw-bold">Ngày lập phiếu</label>
            <input type="date" name="issued_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
        </div>

        <div class="mb-4">
            <label for="" class="form-label fw-bold">Tiền cọc</label>
            <input type="text" name="" class="form-control bg-light" value="{{ number_format($room->price, 0, ',', '.') }} VND" readonly>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">Gửi phiếu</button>
        </div>
    </form>
</div>

@endsection
