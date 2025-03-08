@extends('user.layouts.master')

@section('title', 'Danh sách phòng')

@section('content')
    <!-- Phần bản đồ địa chỉ -->
    <div class="map">
        <iframe
            src="https://www.google.com/maps/embed?..."
            height="500" style="border:0;" allowfullscreen=""></iframe>
        <div class="icon-list">
            <div class="icon icon-1">1</div>
            <div class="icon icon-2">2</div>
            <div class="icon icon-3">3</div>
            <div class="icon icon-4">4</div>
            <div class="icon icon-5">5</div>
        </div>
    </div>
    <!-- Kết thúc Phần bản đồ địa chỉ -->

    <!-- Bắt Đầu Phần Bất Động Sản -->
    <section class="property-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="property-sidebar">
                        <h4 class="search-title">Tìm Kiếm Khu Trọ</h4>
                        <form action="#" class="sidebar-search">
                            <div class="form-group">
                                <input type="text" name="host_name" class="form-control" placeholder="Nhập tên chủ trọ hoặc khu trọ...">
                            </div>
                        
                            <div class="form-group">
                                <label for="search-location"><i class="fas fa-map-marker-alt"></i> Vị trí của bạn:</label>
                                <input type="text" id="search-location" name="search_location" class="form-control" placeholder="Nhập địa chỉ hoặc tọa độ...">
                            </div>
                        
                            {{-- <div class="form-group">
                                <label for="distanceRange"><i class="fas fa-ruler-horizontal"></i> Khoảng cách tối đa:</label>
                                <div class="slider-wrap">
                                    <input type="text" id="distanceRange" class="range-value" readonly>
                                    <div id="distance-range" class="slider"></div>
                                </div>
                            </div> --}}
                        
                            <button type="submit" class="search-btn"><i class="fas fa-search"></i> Tìm Kiếm</button>
                        </form>
                        
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                $("#distance-range").slider({
                                    range: "min",
                                    min: 1,
                                    max: 50,
                                    value: 10,
                                    slide: function(event, ui) {
                                        $("#distanceRange").val(ui.value + " km");
                                    }
                                });
                                $("#distanceRange").val($("#distance-range").slider("value") + " km");
                            });
                        </script>
                    </div>
                </div>
                <div class="col-lg-9">
                    <h4 class="property-title">Danh Sách Khu Trọ</h4>
                    <div class="property-list">
                        <!-- Bắt đầu danh sách khu trọ -->
                        <div class="single-property-item">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="property-pic">
                                        <img src="img/properties/boarding-house-1.jpg" alt="Khu trọ 1">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="property-text">
                                        <h5 class="r-title">Khu Trọ An Phú</h5>
                                        <div class="room-price">
                                            <span>Giá thuê từ:</span>
                                            <h5>2.500.000 VNĐ/tháng</h5>
                                        </div>
                                        <div class="properties-location"><i class="fa fa-map-marker-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</div>
                                        <p>Khu trọ sạch sẽ, an ninh, gần trường học và khu mua sắm.</p>
                                        <ul class="room-features">
                                            <li><i class="fa fa-home"></i><p>10 Phòng</p></li>
                                            <li><i class="fa fa-bed"></i><p>5 Phòng trống</p></li>
                                            <li><i class="fa fa-wifi"></i><p>WiFi miễn phí</p></li>
                                            <li><i class="fa fa-bolt"></i><p>Điện nước giá dân</p></li>
                                        </ul>
                                        <a href="#" class="view-details">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <!-- Lặp lại mẫu trên cho nhiều khu trọ -->
                        <div class="single-property-item">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="property-pic">
                                        <img src="img/properties/boarding-house-2.jpg" alt="Khu trọ 2">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="property-text">
                                        <h5 class="r-title">Nhà Trọ Hoàng Gia</h5>
                                        <div class="room-price">
                                            <span>Giá thuê từ:</span>
                                            <h5>2.800.000 VNĐ/tháng</h5>
                                        </div>
                                        <div class="properties-location"><i class="fa fa-map-marker-alt"></i> 456 Đường XYZ, Quận Bình Thạnh, TP.HCM</div>
                                        <p>Gần chợ, có bảo vệ 24/7, môi trường sống yên tĩnh.</p>
                                        <ul class="room-features">
                                            <li><i class="fa fa-home"></i><p>15 Phòng</p></li>
                                            <li><i class="fa fa-bed"></i><p>3 Phòng trống</p></li>
                                            <li><i class="fa fa-car"></i><p>Bãi giữ xe miễn phí</p></li>
                                            <li><i class="fa fa-couch"></i><p>Nội thất đầy đủ</p></li>
                                        </ul>
                                        <a href="#" class="view-details">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- Kết Thúc Phần Bất Động Sản -->
@endsection