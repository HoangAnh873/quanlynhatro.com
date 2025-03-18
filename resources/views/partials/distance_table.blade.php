<table  class="table table-bordered">
    
    <thead>
        <tr>
            <th>#</th>
            <th>Tên Trường</th>
            <th>Khu trọ</th>
            <th>Khoảng cách</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($distances as $key => $distance)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $distance->school_name }}</td>
            <td>{{ $distance->apartment_name }}</td>
            <td>{{ number_format($distance->distance, 2) }} km</td>
            
        </tr>
        @endforeach
    </tbody>
</table>