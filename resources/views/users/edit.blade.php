@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Tài Khoản</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            @include('partials.user_form')
            <button type="submit" class="btn btn-success">Cập Nhật</button>
        </form>
    </div>
</div>
@endsection
