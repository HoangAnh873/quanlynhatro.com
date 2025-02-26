@extends('layouts.host')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Chủ Trọ</h3>
        <div class="card-tools">
            <a href="{{ route('hosts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm Chủ Trọ
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('partials.host_table', ['hosts' => $hosts])
    </div>
</div>
@endsection
