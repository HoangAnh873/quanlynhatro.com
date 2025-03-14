@extends('user.layouts.master')

@section('title', 'Danh sách phòng')

@section('styles')
<!-- Thêm CSS cho Mapbox vào phần head của trang -->
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<style>
.marker {
    background-size: cover;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    cursor: pointer;
    background-image: url('https://cdn-icons-png.flaticon.com/512/1946/1946433.png');
    filter: invert(18%) sepia(94%) saturate(300%) hue-rotate(310deg) brightness(95%) contrast(100%);
}

    
    .mapboxgl-popup {
        max-width: 300px;
    }
    
    .mapboxgl-popup-content {
        text-align: center;
        padding: 15px;
    }
    
    .apartment-popup-image {
        width: 100%;
        max-height: 120px;
        object-fit: cover;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    
    .apartment-popup-title {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .apartment-popup-price {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .apartment-popup-address {
        font-size: 0.9em;
        margin-bottom: 8px;
    }
    
    .apartment-popup-button {
        display: inline-block;
        background: #3498db;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        text-decoration: none;
        font-size: 0.9em;
    }
    
    .apartment-popup-button:hover {
        background: #2980b9;
        color: white;
    }
</style>
@endsection

@section('content')

    <!-- Phần bản đồ địa chỉ (Hiển thị các khu trọ) -->
    <div class="map-container">
        <div id="apartmentMap" style="width: 100%; height: 500px;"></div>
    </div>
    <!-- Kết thúc Phần bản đồ địa chỉ -->

    <!-- Bắt Đầu Phần Tìm Kiếm Khu Trọ -->
    <section class="property-section spad">
        <div class="container">
            <div class="row">
                <!-- Sidebar Tìm Kiếm -->
                <div class="col-lg-3">
                    <div class="property-sidebar">
                        <h4 class="search-title">Tìm Kiếm Khu Trọ</h4>
                        <form action="{{ route('user.apartments.search') }}" class="sidebar-search">
                            <!-- Ô tìm kiếm chủ trọ hoặc khu trọ -->
                            <div class="form-group">
                                <label for="search-host">
                                    <i class="fas fa-user"></i> Tên chủ trọ hoặc khu trọ:
                                </label>
                                <input type="text" id="search-host" name="host_name" class="form-control" 
                                    placeholder="Nhập tên chủ trọ hoặc khu trọ...">
                            </div>

                            <!-- Ô tìm kiếm theo vị trí -->
                            <div class="form-group">
                                <label for="search-location">
                                    <i class="fas fa-map-marker-alt"></i> Vị trí của bạn:
                                </label>
                                <input type="text" id="search-location" name="search_location" 
                                    class="form-control" placeholder="Nhập địa chỉ hoặc tọa độ...">
                            </div>

                            <!-- Nút Tìm Kiếm -->
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Tìm Kiếm
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Danh Sách Khu Trọ -->
                <div class="col-lg-9">
                    <h4 class="property-title">Danh Sách Khu Trọ</h4>
                    <div class="property-list">
                        @foreach ($apartments as $apartment)
                            <div class="single-property-item apartment-item" 
                                data-lat="{{ $apartment->GPS_Latitude }}" 
                                data-lng="{{ $apartment->GPS_Longitude }}" 
                                data-id="{{ $apartment->id }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="property-pic" style="height: 200px; background-color: #eef5f9; border-radius: 12px; position: relative; overflow: hidden;">
                                            <img src="#" alt="Khu trọ" style="visibility: hidden; width: 100%; height: 100%; object-fit: cover;">
                                            <i class="fa-solid fa-house" style="font-size: 70px; color: #3b82f6; opacity: 0.6; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-8">
                                        <div class="property-text">
                                            <h5 class="r-title">{{ $apartment->name }}</h5>
                                            <div class="properties-owner">
                                                <i class="fa fa-user"></i> Chủ trọ: {{ $apartment->host->user->name ?? 'Không xác định' }}
                                            </div>
                                            <div class="room-price">
                                                <span>Giá thuê từ:</span>
                                                <h5>
                                                    @if ($apartment->roomTypes->count() > 0)
                                                        {{ number_format($apartment->minPrice(), 0, ',', '.') }} VNĐ/tháng
                                                    @else
                                                        Chưa có phòng
                                                    @endif
                                                </h5>
                                            </div>
                                            <div class="properties-location">
                                                <i class="fa fa-map-marker-alt"></i> {{ $apartment->location }}
                                            </div>
                                            <p>{{ $apartment->description }}</p>
                                            <ul class="room-features">
                                                <li><i class="fa fa-home"></i> Có nhà xe</li>
                                                <li><i class="fa fa-bed"></i> Thoải mái</li>
                                                <li><i class="fa fa-wifi"></i> WiFi miễn phí</li>
                                                <li><i class="fa fa-bolt"></i> Điện nước giá dân</li>
                                            </ul>
                                            <a href="{{ route('user.apartments.show', $apartment->id) }}" class="view-details">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                
                        @if ($apartments->isEmpty())
                            <p class="text-center">Không tìm thấy khu trọ nào.</p>
                        @endif
                    </div>
                </div>
                <!-- Kết thúc col-lg-9 -->

            </div> <!-- Kết thúc row -->
        </div> <!-- Kết thúc container -->
    </section>
    <!-- Kết Thúc Phần Tìm Kiếm Khu Trọ -->

@endsection

@section('scripts')
<!-- Tải Mapbox JS -->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM loaded, initializing map");
        initializeMap();
    });
    
    function initializeMap() {
        // Kiểm tra nếu thư viện Mapbox đã được tải
        if (typeof mapboxgl === 'undefined') {
            console.error('Mapbox GL JS không được tải!');
            const mapElement = document.getElementById('apartmentMap');
            if (mapElement) {
                mapElement.innerHTML = '<p class="text-center">Không thể tải bản đồ - Mapbox không khả dụng.</p>';
            }
            return;
        }
        
        try {
            console.log('Đang khởi tạo Mapbox với token');
            mapboxgl.accessToken = 'pk.eyJ1IjoiaG9hbmdhbmhoaCIsImEiOiJjbTg2NXlxbXYwMWRzMmpxeHZxODJ0b2Q1In0.37CjmObFMH_1B04-QE6MtQ';
            
            // Lấy vị trí trung tâm mặc định (Cần Thơ)
            let centerLng = 105.7469;
            let centerLat = 10.0452;
            let defaultZoom = 13;
            
            // Nếu có ít nhất một khu trọ, lấy vị trí của khu trọ đầu tiên làm trung tâm
            const apartmentItems = document.querySelectorAll('.apartment-item');
            if (apartmentItems.length > 0) {
                const firstApartment = apartmentItems[0];
                const lat = parseFloat(firstApartment.dataset.lat);
                const lng = parseFloat(firstApartment.dataset.lng);
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    centerLat = lat;
                    centerLng = lng;
                }
            }
            
            // Tạo bản đồ
            const map = new mapboxgl.Map({
                container: 'apartmentMap',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [centerLng, centerLat],
                zoom: defaultZoom
            });
            
            // Thêm điều khiển điều hướng
            map.addControl(new mapboxgl.NavigationControl());
            
            // Thêm nút vị trí hiện tại
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: true
            }));
            
            // Sự kiện khi map load thành công
            map.on('load', function() {
                console.log('Map has loaded successfully');
                
                // Thêm markers cho tất cả các khu trọ
                apartmentItems.forEach(function(apartment) {
                    const lat = parseFloat(apartment.dataset.lat);
                    const lng = parseFloat(apartment.dataset.lng);
                    const id = apartment.dataset.id;
                    
                    if (!isNaN(lat) && !isNaN(lng)) {
                        // Tạo marker element
                        const el = document.createElement('div');
                        el.className = 'marker';
                        
                        // Lấy thông tin khu trọ để hiển thị trong popup
                        const apartmentName = apartment.querySelector('.r-title').textContent;
                        const apartmentPrice = apartment.querySelector('.room-price h5').textContent;
                        const apartmentLocation = apartment.querySelector('.properties-location').textContent.trim();
                        const apartmentImg = apartment.querySelector('.property-pic img').getAttribute('src');
                        
                        // Tạo nội dung cho popup
                        const popupContent = `
                            <div class="apartment-popup">
                                <img src="${apartmentImg}" alt="${apartmentName}" class="apartment-popup-image">
                                <div class="apartment-popup-title">${apartmentName}</div>
                                <div class="apartment-popup-price">${apartmentPrice}</div>
                                <div class="apartment-popup-address">${apartmentLocation}</div>
                                <a href="${document.location.origin}/user/apartments/${id}" class="apartment-popup-button">Xem chi tiết</a>
                            </div>
                        `;
                        
                        // Tạo popup
                        const popup = new mapboxgl.Popup({ offset: 25 })
                            .setHTML(popupContent);
                        
                        // Thêm marker vào map
                        new mapboxgl.Marker(el)
                            .setLngLat([lng, lat])
                            .setPopup(popup)
                            .addTo(map);
                    }
                });
                
                // Nếu không có khu trọ nào, hiển thị thông báo
                if (apartmentItems.length === 0) {
                    const noApartmentsPopup = new mapboxgl.Popup({ closeOnClick: false })
                        .setLngLat([centerLng, centerLat])
                        .setHTML('<p>Không có khu trọ nào trong khu vực này.</p>')
                        .addTo(map);
                }
            });
            
            // Thêm tính năng click vào danh sách để focus trên bản đồ
            apartmentItems.forEach(function(apartment) {
                apartment.addEventListener('click', function(e) {
                    // Chỉ xử lý nếu người dùng không click vào link xem chi tiết
                    if (!e.target.classList.contains('view-details')) {
                        const lat = parseFloat(this.dataset.lat);
                        const lng = parseFloat(this.dataset.lng);
                        
                        if (!isNaN(lat) && !isNaN(lng)) {
                            map.flyTo({
                                center: [lng, lat],
                                zoom: 15,
                                essential: true
                            });
                        }
                    }
                });
            });
            
            // Bắt sự kiện lỗi
            map.on('error', function(e) {
                console.error('Map error:', e);
            });
        } catch (error) {
            console.error('Error initializing map:', error);
            const mapElement = document.getElementById('apartmentMap');
            if (mapElement) {
                mapElement.innerHTML = '<p class="text-center">Không thể tải bản đồ: ' + error.message + '</p>';
            }
        }
    }
</script>
@endsection