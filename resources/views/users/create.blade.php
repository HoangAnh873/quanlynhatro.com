@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Tài Khoản</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @include('partials.user_form')
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection
