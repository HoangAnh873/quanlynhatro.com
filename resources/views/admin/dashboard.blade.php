@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Báo cáo thống kê</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>10</h3>
                    <p>Chủ Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>15</h3>
                    <p>Khu Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>200</h3>
                    <p>Phòng Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>100</h3>
                    <p>Khách Thuê</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
@stop
