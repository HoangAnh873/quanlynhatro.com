@extends('adminlte::page')

@section('title', 'Danh sách Phòng')

@section('content_header')
    <h1>Quản lý hợp đồng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách phòng</h3>
        {{-- <a href="#" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Thêm hợp đồng mới</a> --}}
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

        <!-- Bảng danh sách hợp đồng -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Phòng</th>
                    <th>Khách thuê</th>
                    <th>SDT</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Tiền cọc</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contracts as $contract)
                    <tr>
                        {{-- <td>{{ $contract->id }}</td> --}}
                        <td>{{ $contract->room->room_number ?? 'Không xác định' }}</td>
                        <td>{{ $contract->tenant->full_name ?? 'Không xác định' }}</td>
                        <td>{{ $contract->tenant->phone ?? 'Không xác định' }}</td>
                        <td>{{ $contract->start_date }}</td>
                        <td>{{ $contract->end_date }}</td>
                        <td>{{ number_format($contract->deposit) }} VNĐ</td>
                        <td>
                            @if($contract->end_date > now())
                                <form action="{{ route('host.contracts.cancel', $contract->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy hợp đồng này không?');">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm">Hủy hợp đồng</button>
                                </form>
                            @else
                                <span class="text-muted">Đã kết thúc</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script AJAX để lấy danh sách hợp đồng theo khu trọ -->
@section('js')
<script>
    document.getElementById('apartmentSelect').addEventListener('change', function() {
        let apartmentId = this.value;
        let contractList = document.getElementById('contract-list');

        if (!apartmentId) {
            contractList.innerHTML = "<tr><td colspan='6' class='text-center'>Vui lòng chọn khu trọ</td></tr>";
            return;
        }

        fetch(`/host/contracts/by-apartment/${apartmentId}`)
            .then(response => response.json())
            .then(data => {
                let html = "";
                if (data.length > 0) {
                    data.forEach(contract => {
                        html += `
                            <tr>
                                <td>${contract.id}</td>
                                <td>${contract.room.name}</td>
                                <td>${contract.tenant.name}</td>
                                <td>${contract.start_date}</td>
                                <td>${contract.end_date}</td>
                                <td>${new Intl.NumberFormat().format(contract.deposit)} VNĐ</td>
                            </tr>
                        `;
                    });
                } else {
                    html = "<tr><td colspan='6' class='text-center'>Không có hợp đồng nào trong khu trọ này</td></tr>";
                }
                contractList.innerHTML = html;
            })
            .catch(error => console.error('Lỗi:', error));
    });
</script>
@endsection
@endsection