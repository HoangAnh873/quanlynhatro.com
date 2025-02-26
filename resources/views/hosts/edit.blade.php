@extends('layouts.host')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Chủ Trọ</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('hosts.update', $host->id) }}" method="POST">
            @csrf @method('PUT')
            @include('partials.host_form')
            <button type="submit" class="btn btn-success">Cập Nhật</button>
        </form>
    </div>
</div>
@endsection
