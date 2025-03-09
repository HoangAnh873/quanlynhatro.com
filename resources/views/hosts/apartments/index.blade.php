@extends('adminlte::page')

@section('title', 'Quản lý Khu Trọ')

@section('content_header')
    <h1>Quản lý Khu Trọ</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách Khu Trọ</h3>
                <div class="card-tools">
                    <a href="{{ route('host.apartments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Thêm Khu Trọ
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Khu Trọ</th>
                            <th>Địa Chỉ</th>
                            <th>Vĩ Độ</th>
                            <th>Kinh Độ</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $apartment)
                            <tr>
                                <td>{{ $apartment->id }}</td>
                                <td>{{ $apartment->name }}</td>
                                <td>{{ $apartment->location }}</td>
                                <td>{{ $apartment->GPS_Latitude }}</td>
                                <td>{{ $apartment->GPS_Longitude }}</td>
                                <td>
                                    <a href="{{ route('host.apartments.edit', $apartment->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <form action="{{ route('host.apartments.destroy', $apartment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
