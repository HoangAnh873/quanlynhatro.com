@extends('adminlte::page')

@section('title', 'Báo Cáo Thống Kê')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-chart-bar text-primary mr-2"></i> Báo Cáo Thống Kê</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active">Báo cáo thống kê</li>
        </ol>
    </div>
@stop

@section('content')
    <!-- Thẻ thống kê tổng quan -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info elevation-3">
                <div class="inner">
                    <h3>{{ number_format($hostCount) }}</h3>
                    <p>Chủ Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                {{-- <a href="{{ route('hosts.index') }}" class="small-box-footer">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success elevation-3">
                <div class="inner">
                    <h3>{{ number_format($apartmentCount) }}</h3>
                    <p>Khu Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                {{-- <a href="{{ route('apartments.index') }}" class="small-box-footer">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning elevation-3">
                <div class="inner">
                    <h3>{{ number_format($roomCount) }}</h3>
                    <p>Phòng Trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
                {{-- <a href="{{ route('rooms.index') }}" class="small-box-footer">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger elevation-3">
                <div class="inner">
                    <h3>{{ number_format($tenantCount) }}</h3>
                    <p>Khách Thuê</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                {{-- <a href="{{ route('tenants.index') }}" class="small-box-footer">
                    Chi tiết <i class="fas fa-arrow-circle-right"></i>
                </a> --}}
            </div>
        </div>
    </div>

    <!-- Biểu đồ và thống kê số lượng khách thuê theo thàng -->
    <div class="row">
        <!-- Biểu đồ số lượng khách thuê theo tháng -->
        <div class="col-md-8">
            <div class="card card-primary card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Thống kê số lượng khách thuê theo tháng
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="tenantChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ phân loại khách thuê -->
        <div class="col-md-4">
            <div class="card card-success card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-1"></i>
                        Phân loại khách thuê
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="tenantTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm hàng mới với biểu đồ thời hạn hợp đồng -->
    {{-- <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-info card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-area mr-1"></i>
                        Thống kê hợp đồng theo thời hạn
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:250px;">
                        <canvas id="contractDurationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

@stop

@section('css')
    <style>
        .small-box {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
        }
        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .chart-container {
            margin: 0 auto;
        }
        .card {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .card-header {
            border-bottom: none;
        }
        .card-title {
            font-weight: 600;
        }
        .bg-gradient-info {
            background: linear-gradient(45deg, #3498db, #5dade2);
        }
        .bg-gradient-success {
            background: linear-gradient(45deg, #2ecc71, #58d68d);
        }
        .bg-gradient-warning {
            background: linear-gradient(45deg, #f39c12, #f5b041);
        }
        .bg-gradient-danger {
            background: linear-gradient(45deg, #e74c3c, #ec7063);
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            // Tạo gradient cho biểu đồ
            function createGradient(ctx, startColor, endColor) {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, startColor);
                gradient.addColorStop(1, endColor);
                return gradient;
            }
            
            // Biểu đồ số lượng khách thuê theo tháng
            var tenantCtx = document.getElementById('tenantChart').getContext('2d');
            var tenantGradient = createGradient(tenantCtx, 'rgba(60, 141, 188, 0.8)', 'rgba(60, 141, 188, 0.2)');
            var tenantChart = new Chart(tenantCtx, {
                type: 'bar',
                data: {
                    labels: ['Tháng 10/2024', 'Tháng 11/2024', 'Tháng 12/2024', 'Tháng 1/2025', 'Tháng 2/2025', 'Tháng 3/2025'],
                    datasets: [{
                        label: 'Số lượng khách thuê',
                        data: [45, 52, 48, 56, 62, 70],
                        backgroundColor: tenantGradient,
                        borderColor: 'rgba(60, 141, 188, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw + ' khách';
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
            
            // Biểu đồ phân loại khách thuê
            var typeCtx = document.getElementById('tenantTypeChart').getContext('2d');
            var tenantTypeChart = new Chart(typeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sinh viên', 'Nhân viên văn phòng', 'Gia đình', 'Khác'],
                    datasets: [{
                        data: [42, 28, 18, 12],
                        backgroundColor: [
                            '#3498db',
                            '#2ecc71',
                            '#f39c12',
                            '#9b59b6'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 13
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleFont: {
                                size: 14
                            },
                            bodyFont: {
                                size: 13
                            },
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    },
                    cutout: '65%',
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
            
            // Biểu đồ thời hạn hợp đồng
            var durationCtx = document.getElementById('contractDurationChart').getContext('2d');
            var durationGradient = createGradient(durationCtx, 'rgba(29, 209, 161, 0.8)', 'rgba(29, 209, 161, 0.1)');
            var contractDurationChart = new Chart(durationCtx, {
                type: 'line',
                data: {
                    labels: ['Tháng 10', 'Tháng 11', 'Tháng 12', 'Tháng 1', 'Tháng 2', 'Tháng 3'],
                    datasets: [
                        {
                            label: 'Hợp đồng 6 tháng',
                            data: [18, 22, 20, 25, 27, 32],
                            fill: true,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)'
                        },
                        {
                            label: 'Hợp đồng 12 tháng',
                            data: [27, 30, 28, 31, 35, 38],
                            fill: true,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(75, 192, 192, 1)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            mode: 'index',
                            intersect: false,
                            padding: 10
                        }
                    },
                    elements: {
                        point: {
                            radius: 3,
                            hoverRadius: 7
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    animation: {
                        duration: 2000
                    }
                }
            });
        });
    </script>
@stop