<table class="table table-bordered">
    <thead>
        <tr>
            <th>STT</th>
            <th>Icon</th>
            <th>Tên Trường</th>
            <th>Địa Chỉ</th>
            <th>Vĩ Độ</th>
            <th>Kinh Độ</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($schools as $key => $school)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                @if ($school->icon)
                    <img src="{{ asset('img/icons/' . $school->icon) }}" alt="Icon" width="40" height="40">
                @else
                    <span class="text-muted">Chưa có icon</span>
                @endif
            </td>
            <td>{{ $school->name }}</td>
            <td>{{ $school->location ?? 'N/A' }}</td>
            <td>{{ $school->GPS_Latitude ?? 'N/A' }}</td>
            <td>{{ $school->GPS_Longitude ?? 'N/A' }}</td>
            <td>
                <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Sửa
                </a>
                <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?');">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
