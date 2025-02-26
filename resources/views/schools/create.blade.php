@extends('layouts.school')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Thêm Trường Học</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('schools.store') }}" method="POST">
            @csrf
            @include('partials.school_form')
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
@endsection
