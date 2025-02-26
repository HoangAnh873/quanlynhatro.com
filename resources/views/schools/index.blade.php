@extends('layouts.school')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh Sách Trường Học</h3>
        <div class="card-tools">
            <a href="{{ route('schools.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Thêm Trường Học
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('partials.school_table', ['schools' => $schools])
    </div>
</div>
@endsection
