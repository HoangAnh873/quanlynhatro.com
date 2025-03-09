@extends('adminlte::page')

@section('title', 'Chỉnh Sửa Khu Trọ')

@section('content_header')
    <h1>Quản lý Khu Trọ</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Thông tin Khu Trọ</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('host.apartments.update', $apartment->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Tên Khu Trọ</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ $apartment->name }}" required>
            </div>

            <div class="form-group">
                <label for="location">Địa Chỉ</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ $apartment->location }}" required>
            </div>

            <div class="form-group">
                <label for="GPS_Latitude">Vĩ Độ (Latitude)</label>
                <input type="text" id="GPS_Latitude" name="GPS_Latitude" class="form-control" value="{{ $apartment->GPS_Latitude }}">
            </div>

            <div class="form-group">
                <label for="GPS_Longitude">Kinh Độ (Longitude)</label>
                <input type="text" id="GPS_Longitude" name="GPS_Longitude" class="form-control" value="{{ $apartment->GPS_Longitude }}">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Cập Nhật</button>
                <a href="{{ route('host.apartments.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</div>
@endsection
