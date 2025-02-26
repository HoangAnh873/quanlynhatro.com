@extends('layouts.school')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sửa Trường Học</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('schools.update', $school->id) }}" method="POST">
            @csrf @method('PUT')
            @include('partials.school_form')
            <button type="submit" class="btn btn-success">Cập Nhật</button>
        </form>
    </div>
</div>
@endsection
