@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Quản lý trường học</h1>
@stop

@section('content')
    <div class="wrapper">
        <!-- Nội dung chính -->
        <div class="content-wrapper">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

    </div>
@stop