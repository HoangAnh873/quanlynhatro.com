@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Báo cáo thống kê</h1>
@stop

@section('css')
    <style>
        .small-box {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .small-box .icon {
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        .small-box:hover .icon {
            opacity: 1;
        }
        .small-box .inner {
            padding: 20px;
        }
        .small-box .inner h3 {
            font-weight: 600;
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .small-box .inner p {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .chart-container {
            margin: 0 auto;
        }
        .card {
            border-radius: 10px;
            transition: box-shadow 0.3s;
            margin-bottom: 20px;
            border: none;
        }
        .card:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-bottom: none;
            background-color: transparent;
            padding: 15px 20px;
        }
        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0;
        }
        .card-body {
            padding: 15px 20px 20px;
        }
        .bg-info {
            background: linear-gradient(45deg, #2196F3, #64B5F6) !important;
        }
        .bg-success {
            background: linear-gradient(45deg, #28a745, #5fd778) !important;
        }
        .bg-warning {
            background: linear-gradient(45deg, #FF9800, #FFC107) !important;
        }
        .bg-primary {
            background: linear-gradient(45deg, #007bff, #4da3ff) !important;
        }
        .elevation-3 {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08) !important;
        }
        .content-header h1 {
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        .content-header h1:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #007bff;
            border-radius: 3px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $tenantCount }}</h3>
                    <p>khách thuê</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $roomCount }}</h3>
                    <p>phòng trọ</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $emptyRoomCount }}</h3>
                    <p>phòng trống</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $pendingRentals }}</h3>
                    <p>phiếu đợi duyệt</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm vào sau các ô thống kê nhỏ -->
    <div class="row">
        <!-- Biểu đồ doanh thu của chủ trọ theo tháng -->
        <div class="col-md-8">
            <div class="card card-primary card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Thống kê doanh thu theo tháng
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="hostRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ tỷ lệ phòng theo chủ trọ -->
        <div class="col-md-4">
            <div class="card card-success card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Tỷ lệ phòng trọ theo khu trọ
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="hostRoomDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Hàng thứ hai của biểu đồ -->
    <div class="row mt-4">
        <!-- Biểu đồ tỷ lệ phòng đã thuê / còn trống theo chủ trọ -->
        <div class="col-md-6">
            <div class="card card-warning card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-percentage mr-1"></i>
                        Tỷ lệ lấp đầy phòng trọ
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 280px;">
                        <canvas id="roomOccupancyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ thời hạn hợp đồng theo chủ trọ -->
        <div class="col-md-6">
            <div class="card card-info card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Số lượng hợp đồng theo thời hạn
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 280px;">
                        <canvas id="contractDurationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hàng thứ ba của biểu đồ -->
    <div class="row mt-4">
        <!-- Biểu đồ so sánh 5 chủ trọ có nhiều phòng nhất -->
        <div class="col-md-12">
            <div class="card card-danger card-outline elevation-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-award mr-1"></i>
                        Top 5 chủ trọ có nhiều phòng nhất
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 250px;">
                        <canvas id="topHostsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
            
            // Biểu đồ doanh thu theo tháng
            var revenueCtx = document.getElementById('hostRevenueChart').getContext('2d');
            var revenueGradient = createGradient(revenueCtx, 'rgba(0, 123, 255, 0.8)', 'rgba(0, 123, 255, 0.2)');
            var hostRevenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Tháng 10/2024', 'Tháng 11/2024', 'Tháng 12/2024', 'Tháng 1/2025', 'Tháng 2/2025', 'Tháng 3/2025'],
                    datasets: [{
                        label: 'Doanh thu (triệu VNĐ)',
                        data: [85, 92, 95, 88, 97, 105],
                        backgroundColor: revenueGradient,
                        borderColor: 'rgba(0, 123, 255, 1)',
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
                                callback: function(value) {
                                    return value + ' tr';
                                },
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
                                    return context.dataset.label + ': ' + context.raw + ' triệu VNĐ';
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
            
            // Biểu đồ tỷ lệ phòng theo chủ trọ
            var distributionCtx = document.getElementById('hostRoomDistributionChart').getContext('2d');
            var hostRoomDistributionChart = new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Minh Hường', 'Diễm Quỳnh', 'Hoàng Anh', 'Hoàng Gia', 'Khác'],
                    datasets: [{
                        data: [30, 25, 20, 15, 10],
                        backgroundColor: [
                            '#3498db',
                            '#2ecc71',
                            '#f39c12',
                            '#9b59b6',
                            '#e74c3c'
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
            
            // Biểu đồ tỷ lệ lấp đầy phòng trọ
            var occupancyCtx = document.getElementById('roomOccupancyChart').getContext('2d');
            var roomOccupancyChart = new Chart(occupancyCtx, {
                type: 'bar',
                data: {
                    labels: ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Thị D', 'Hoàng Văn E'],
                    datasets: [
                        {
                            label: 'Phòng đã thuê',
                            data: [25, 18, 15, 12, 10],
                            backgroundColor: 'rgba(46, 204, 113, 0.7)',
                            borderColor: 'rgba(46, 204, 113, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        },
                        {
                            label: 'Phòng trống',
                            data: [5, 7, 5, 3, 5],
                            backgroundColor: 'rgba(231, 76, 60, 0.7)',
                            borderColor: 'rgba(231, 76, 60, 1)',
                            borderWidth: 1,
                            borderRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
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
                            intersect: false
                        }
                    },
                    animation: {
                        duration: 2000
                    }
                }
            });
            
            // Biểu đồ số lượng hợp đồng theo thời hạn
            var durationCtx = document.getElementById('contractDurationChart').getContext('2d');
            var contractDurationChart = new Chart(durationCtx, {
                type: 'pie',
                data: {
                    labels: ['3 tháng', '6 tháng', '12 tháng', 'Trên 12 tháng'],
                    datasets: [{
                        data: [15, 35, 40, 10],
                        backgroundColor: [
                            '#f1c40f',
                            '#3498db',
                            '#2ecc71',
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
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                pointStyleWidth: 10
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw + '%';
                                }
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true
                    }
                }
            });
            
            // Biểu đồ Top 5 chủ trọ có nhiều phòng nhất
            var topHostsCtx = document.getElementById('topHostsChart').getContext('2d');
            var horizontalGradient = topHostsCtx.createLinearGradient(0, 0, 800, 0);
            horizontalGradient.addColorStop(0, 'rgba(233, 30, 99, 0.8)');
            horizontalGradient.addColorStop(1, 'rgba(233, 30, 99, 0.2)');
            
            var topHostsChart = new Chart(topHostsCtx, {
                type: 'bar',
                data: {
                    labels: ['Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Thị D', 'Hoàng Văn E'],
                    datasets: [{
                        label: 'Số phòng',
                        data: [30, 25, 20, 15, 12],
                        backgroundColor: horizontalGradient,
                        borderColor: 'rgba(233, 30, 99, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        barPercentage: 0.5
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                precision: 0
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            callbacks: {
                                label: function(context) {
                                    return 'Số phòng: ' + context.raw;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000
                    }
                }
            });
        });
    </script>
@stop
