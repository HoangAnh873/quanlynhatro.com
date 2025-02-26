@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Tài Khoản</h3>
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm Tài Khoản
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('partials.user_table', ['users' => $users])
    </div>
</div>
@endsection
