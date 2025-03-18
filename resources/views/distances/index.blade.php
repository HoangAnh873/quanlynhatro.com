@extends('layouts.distance')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Khoảng Cách Giữa Trường Học và Căn Hộ</h3>
        <div class="card-tools">
        </div>
    </div>
    <div class="card-body">
        @include('partials.distance_table', ['distances' => $distances])
    </div>
</div>
@endsection