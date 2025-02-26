@extends('layouts.host')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Chủ Trọ</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('hosts.store') }}" method="POST">
            @csrf
            @include('partials.host_form')
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection
