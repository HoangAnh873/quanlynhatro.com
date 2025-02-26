<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên Chủ Trọ</th>
            <th>Số Điện Thoại</th>
            <th>Địa Chỉ</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hosts as $key => $host)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $host->user->name ?? 'N/A' }}</td>
            <td>{{ $host->phone }}</td>
            <td>{{ $host->address }}</td>
            <td>
                <a href="{{ route('hosts.edit', $host->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <form action="{{ route('hosts.destroy', $host->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
