@extends('adminlte::page')

@section('title', 'Duyệt phiếu thuê phòng')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Danh Sách Phiếu Thuê Phòng</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khu Trọ</th>
                <th>Phòng Trọ</th>
                <th>Người Thuê</th>
                <th>Số Điện Thoại</th>
                <th>Ngày Bắt Đầu</th>
                <th>Ngày Kết Thúc</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentalReceipts as $receipt)
                <tr>
                    <td>{{ $receipt->id }}</td>
                    <td>{{ $receipt->room->apartment->name }}</td> <!-- Lấy tên khu trọ -->
                    <td>{{ $receipt->room->room_number }}</td> <!-- Lấy tên phòng trọ -->
                    <td>{{ $receipt->tenant->full_name }}</td>
                    <td>{{ $receipt->tenant->phone }}</td>
                    <td>{{ $receipt->start_date }}</td>
                    <td>{{ $receipt->end_date }}</td>
                    
                    <td>
                        @if($receipt->status === 'pending')
                            <form action="{{ route('host.rentals.approve', $receipt->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-success">Duyệt</button>
                            </form>
                            
                            <form action="{{ route('host.rentals.reject', $receipt->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn từ chối phiếu thuê này không?');">
                                @csrf
                                <input type="hidden" name="_method" value="PATCH">
                                <button class="btn btn-sm btn-danger">Từ chối</button>
                            </form>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop
