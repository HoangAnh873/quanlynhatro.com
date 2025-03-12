@extends('adminlte::page')

@section('title', 'Quản lý Loại Phòng')

@section('content_header')
    <h1>Quản lý Loại Phòng</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách Loại Phòng</h3>
                <div class="card-tools">
                    <a href="{{ route('host.types.create', ['apartment_id' => $selectedApartment->id]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm Loại Phòng
                    </a>
                </div>
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
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Loại Phòng</th>
                            <th>Số Người Tối Đa</th>
                            <th>Diện Tích (m²)</th>
                            <th>Giá Thuê (VNĐ)</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($typeRooms as $roomType)
                            <tr>
                                <td>{{ $roomType->id }}</td>
                                <td>{{ $roomType->name }}</td>
                                <td>{{ $roomType->max_occupants }}</td>
                                <td>{{ $roomType->area }}</td>
                                <td>{{ number_format($roomType->price, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    <a href="{{ route('host.types.edit', $roomType->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('host.types.destroy', $roomType->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
    </div>
</div>
@stop
