@extends('user.layouts.master')

@section('title', 'Danh sách phòng')

@section('styles')
<!-- Thêm CSS cho Mapbox vào phần head của trang -->
<link href='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css' rel='stylesheet' />
<!-- Thêm CSS cho Directions API -->
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">
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
        margin-right: 5px;
    }
    
    .apartment-popup-button:hover {
        background: #2980b9;
        color: white;
    }
    
    .directions-button {
        display: inline-block;
        background: #27ae60;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        text-decoration: none;
        font-size: 0.9em;
        cursor: pointer;
    }
    
    .directions-button:hover {
        background: #219653;
        color: white;
    }
    
    /* Ẩn directions container mặc định */
    .directions-container {
        position: absolute;
        top: 0;
        right: 0;
        background: white;
        width: 320px;
        height: 100%;
        display: none;
        z-index: 1;
    }
    
    /* Nút đóng directions */
    .close-directions {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        font-size: 14px;
        line-height: 1;
        cursor: pointer;
        z-index: 3;
    }
    
    /* Style cho thông báo kết quả tìm kiếm */
    .search-results-message {
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        background-color: #eef5f9;
        border-left: 5px solid #3498db;
        font-weight: 500;
    }
    
    /* Style cho vòng tròn hiển thị vị trí người dùng */
    .current-location-marker {
        background-color: #3498db;
        border: 2px solid white;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(52, 152, 219, 0.4);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(52, 152, 219, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(52, 152, 219, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(52, 152, 219, 0);
        }
    }
</style>
@endsection

@section('content')

    <!-- Phần bản đồ địa chỉ (Hiển thị các khu trọ) -->
    <div class="map-container" style="position: relative;">
        <div id="apartmentMap" style="width: 100%; height: 500px;"></div>
        <!-- Container cho directions -->
        <div id="directions-container" class="directions-container">
            <button id="close-directions" class="close-directions">×</button>
        </div>
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
                                    class="form-control" placeholder="Để trống để sử dụng vị trí hiện tại...">
                            </div>
                            
                            <!-- Ô chọn bán kính tìm kiếm -->
                            <div class="form-group">
                                <label for="search-radius">
                                    <i class="fas fa-circle-notch"></i> Bán kính tìm kiếm:
                                </label>
                                <select id="search-radius" name="radius" class="form-control">
                                    <option value="1">1 km</option>
                                    <option value="2">2 km</option>
                                    <option value="5" selected>5 km</option>
                                    <option value="10">10 km</option>
                                    <option value="20">20 km</option>
                                    <option value="50">50 km</option>
                                </select>
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
                                            {{-- <a href="{{ route('user.apartments.show', $apartment->id) }}" class="view-details">Xem chi tiết</a> --}}
                                            <a href="{{ route('user.apartments.showRoom', $apartment->id) }}" class="view-details">Xem phòng</a>
                                            <button class="directions-button" 
                                                data-lat="{{ $apartment->GPS_Latitude }}" 
                                                data-lng="{{ $apartment->GPS_Longitude }}"
                                                data-name="{{ $apartment->name }}">
                                                <i class="fa fa-route"></i> Chỉ đường
                                            </button>
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
    <!-- Tải Turf.js để vẽ vòng tròn bán kính -->
    <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
    <!-- Tải Mapbox JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <!-- Tải Mapbox Directions Plugin -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log("DOM loaded, initializing map");
            initializeMap();
        });


        let map, directions;
        let userLocation = null;
        let radiusCircle = null;
        let markers = []; // Mảng để lưu trữ tất cả các marker


        // Hàm tính khoảng cách giữa hai điểm theo công thức Haversine (đơn vị: km)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Bán kính Trái Đất (km)
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            const distance = R * c; // Khoảng cách (km)
            return distance;
        }
       
        // Hàm xóa tất cả marker trên bản đồ
        function removeAllMarkers() {
            markers.forEach(marker => marker.remove());
            markers = [];
        }


        // Hàm thêm marker cho vị trí tìm kiếm
        function addSearchLocationMarker(lat, lng) {
            const marker = new mapboxgl.Marker({
                color: '#FF0000', // Marker màu đỏ để phân biệt
                draggable: false
            })
            .setLngLat([lng, lat])
            .addTo(map);
            markers.push(marker);
        }


        // Hàm lọc các khu trọ trong bán kính cho trước
        function filterApartmentsByRadius(centerLat, centerLng, radius) {
            const apartmentItems = document.querySelectorAll('.apartment-item');
            let visibleCount = 0;


            apartmentItems.forEach(function(apartment) {
                const lat = parseFloat(apartment.dataset.lat);
                const lng = parseFloat(apartment.dataset.lng);


                if (!isNaN(lat) && !isNaN(lng)) {
                    const distance = calculateDistance(centerLat, centerLng, lat, lng);


                    // Hiển thị khu trọ nếu nằm trong bán kính
                    if (distance <= radius) {
                        apartment.style.display = 'block';
                        visibleCount++;
                    } else {
                        apartment.style.display = 'none';
                    }
                }
            });


            return visibleCount;
        }




       
       


        function initializeMap() {
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


                let centerLng = 105.7469;
                let centerLat = 10.0452;
                let defaultZoom = 13;


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


                map = new mapboxgl.Map({
                    container: 'apartmentMap',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [centerLng, centerLat],
                    zoom: defaultZoom
                });


                directions = new MapboxDirections({
                    accessToken: mapboxgl.accessToken,
                    unit: 'metric',
                    profile: 'mapbox/driving',
                    alternatives: true,
                    congestion: true,
                    language: 'vi',
                    controls: {
                        inputs: true,
                        instructions: true,
                        profileSwitcher: true
                    },
                    placeholderOrigin: 'Vị trí của bạn',
                    placeholderDestination: 'Khu trọ đích',
                    flyTo: true
                });


                document.getElementById('directions-container').appendChild(
                    directions.onAdd(map)
                );


                map.addControl(new mapboxgl.NavigationControl());


                const geolocateControl = new mapboxgl.GeolocateControl({
                    positionOptions: {
                        enableHighAccuracy: true
                    },
                    trackUserLocation: true,
                    showUserHeading: true
                });


                map.addControl(geolocateControl);


                geolocateControl.on('geolocate', function(e) {
                    userLocation = {
                        lng: e.coords.longitude,
                        lat: e.coords.latitude
                    };
                    console.log('User location:', userLocation);
                });


                map.on('load', function() {
                    console.log('Map has loaded successfully');


                    apartmentItems.forEach(function(apartment) {
                        const lat = parseFloat(apartment.dataset.lat);
                        const lng = parseFloat(apartment.dataset.lng);
                        const id = apartment.dataset.id;


                        if (!isNaN(lat) && !isNaN(lng)) {
                            const el = document.createElement('div');
                            el.className = 'marker';


                            const apartmentName = apartment.querySelector('.r-title').textContent;
                            const apartmentPrice = apartment.querySelector('.room-price h5').textContent;
                            const apartmentLocation = apartment.querySelector('.properties-location').textContent.trim();
                            const apartmentImg = apartment.querySelector('.property-pic img').getAttribute('src');


                            const popupContent = `
                                <div class="apartment-popup">
                                    <img src="${apartmentImg}" alt="${apartmentName}" class="apartment-popup-image">
                                    <div class="apartment-popup-title">${apartmentName}</div>
                                    <div class="apartment-popup-price">${apartmentPrice}</div>
                                    <div class="apartment-popup-address">${apartmentLocation}</div>
                                    <a href="${document.location.origin}/user/apartments/${id}" class="apartment-popup-button">Xem chi tiết</a>
                                    <button class="directions-button" data-lat="${lat}" data-lng="${lng}" data-name="${apartmentName}">
                                        <i class="fa fa-route"></i> Chỉ đường
                                    </button>
                                </div>
                            `;


                            const popup = new mapboxgl.Popup({ offset: 25 })
                                .setHTML(popupContent);


                            const marker = new mapboxgl.Marker(el)
                                .setLngLat([lng, lat])
                                .setPopup(popup)
                                .addTo(map);
                            markers.push(marker);
                        }
                    });


                    if (apartmentItems.length === 0) {
                        const noApartmentsPopup = new mapboxgl.Popup({ closeOnClick: false })
                            .setLngLat([centerLng, centerLat])
                            .setHTML('<p>Không có khu trọ nào trong khu vực này.</p>')
                            .addTo(map);
                    }


                    const urlParams = new URLSearchParams(window.location.search);
                    const hostNameQuery = urlParams.get('host_name');


                    if (hostNameQuery) {
                        console.log('Tìm kiếm theo chủ trọ/khu trọ:', hostNameQuery);
                        filterApartmentsByName(hostNameQuery);
                    }


                    function filterApartmentsByName(searchQuery) {
                        searchQuery = searchQuery.toLowerCase().trim();
                        let visibleCount = 0;
                        const bounds = new mapboxgl.LngLatBounds();


                        apartmentItems.forEach(function(apartment) {
                            const apartmentName = apartment.querySelector('.r-title')?.textContent.toLowerCase() || '';
                            const hostName = apartment.querySelector('.properties-owner')?.textContent.toLowerCase() || '';


                            if (apartmentName.includes(searchQuery) || hostName.includes(searchQuery)) {
                                apartment.style.display = '';
                                const lat = parseFloat(apartment.dataset.lat);
                                const lng = parseFloat(apartment.dataset.lng);


                                if (!isNaN(lat) && !isNaN(lng)) {
                                    bounds.extend([lng, lat]);
                                    visibleCount++;
                                }
                            } else {
                                apartment.style.display = 'none';
                            }
                        });


                        if (visibleCount > 0) {
                            map.fitBounds(bounds, {
                                padding: 50,
                                maxZoom: 15
                            });
                            showFilterResultMessage(`Tìm thấy ${visibleCount} khu trọ phù hợp với "${searchQuery}"`);
                        } else {
                            showFilterResultMessage(`Không tìm thấy khu trọ nào phù hợp với "${searchQuery}"`);
                        }
                    }


                    function showFilterResultMessage(message) {
                        let messageElement = document.getElementById('filter-result-message');
                        if (!messageElement) {
                            messageElement = document.createElement('div');
                            messageElement.id = 'filter-result-message';
                            messageElement.className = 'filter-result-message';
                            const mapContainer = document.getElementById('apartmentMap').parentNode;
                            mapContainer.insertBefore(messageElement, mapContainer.firstChild);
                        }


                        messageElement.textContent = message;
                        messageElement.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
                        messageElement.style.color = 'white';
                        messageElement.style.padding = '10px 15px';
                        messageElement.style.borderRadius = '5px';
                        messageElement.style.margin = '10px 0';
                        messageElement.style.fontWeight = 'bold';


                        setTimeout(() => {
                            if (messageElement) {
                                messageElement.style.opacity = '0';
                                messageElement.style.transition = 'opacity 1s';
                                setTimeout(() => {
                                    if (messageElement.parentNode) {
                                        messageElement.parentNode.removeChild(messageElement);
                                    }
                                }, 1000);
                            }
                        }, 5000);
                    }


                    if (urlParams.has('search_location') || urlParams.has('host_name') || urlParams.has('radius')) {
                        console.log('Tìm kiếm thành công, hiển thị kết quả trên bản đồ');


                        if (apartmentItems.length > 0) {
                            const bounds = new mapboxgl.LngLatBounds();
                            apartmentItems.forEach(function(apartment) {
                                const lat = parseFloat(apartment.dataset.lat);
                                const lng = parseFloat(apartment.dataset.lng);
                                if (!isNaN(lat) && !isNaN(lng)) {
                                    bounds.extend([lng, lat]);
                                }
                            });
                            map.fitBounds(bounds, {
                                padding: 50,
                                maxZoom: 15
                            });
                        }


                        if (urlParams.has('search_location') && urlParams.has('radius')) {
                            const address = urlParams.get('search_location');
                            const radius = parseFloat(urlParams.get('radius'));


                            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxgl.accessToken}&country=VN&limit=1&types=address,poi`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.features && data.features.length > 0) {
                                        const searchLng = data.features[0].center[0];
                                        const searchLat = data.features[0].center[1];
                                        drawRadiusCircle(searchLat, searchLng, radius);
                                    }
                                })
                                .catch(error => {
                                    console.error('Lỗi tìm kiếm địa chỉ:', error);
                                });
                        }
                    }
                });


                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('directions-button') ||
                        e.target.parentElement.classList.contains('directions-button')) {
                        const button = e.target.classList.contains('directions-button') ?
                            e.target : e.target.parentElement;
                        const lat = parseFloat(button.dataset.lat);
                        const lng = parseFloat(button.dataset.lng);
                        const name = button.dataset.name;


                        if (!isNaN(lat) && !isNaN(lng)) {
                            showDirections(lat, lng, name);
                        }
                    }
                });


                document.getElementById('close-directions').addEventListener('click', function() {
                    hideDirections();
                });


                    apartmentItems.forEach(function(apartment) {
                        const directionsButton = apartment.querySelector('.directions-button');
                        if (directionsButton) {
                            directionsButton.addEventListener('click', function() {
                                const lat = parseFloat(this.dataset.lat);
                                const lng = parseFloat(this.dataset.lng);
                                const name = this.dataset.name;


                                if (!isNaN(lat) && !isNaN(lng)) {
                                    showDirections(lat, lng, name);
                                }
                            });
                        }


                        apartment.addEventListener('click', function(e) {
                            if (!e.target.classList.contains('view-details') &&
                                !e.target.classList.contains('directions-button') &&
                                !e.target.parentElement.classList.contains('directions-button')) {
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


                map.on('error', function(e) {
                    console.error('Map error:', e);
                });


                document.querySelector('.sidebar-search').addEventListener('submit', function(e) {
                    e.preventDefault();


                    const hostName = document.getElementById('search-host').value.trim();
                    const searchLocation = document.getElementById('search-location').value.trim();
                    const radius = parseFloat(document.getElementById('search-radius').value);
                   
                    if (searchLocation === '') {
                        if (userLocation) {
                            searchByCurrentLocation(hostName, radius);
                        } else {
                            navigator.geolocation.getCurrentPosition(
                                function(position) {
                                    userLocation = {
                                        lng: position.coords.longitude,
                                        lat: position.coords.latitude
                                    };
                                    searchByCurrentLocation(hostName, radius);
                                },
                                function(error) {
                                    console.error('Lỗi lấy vị trí người dùng:', error);
                                    alert('Không thể lấy vị khung vực của bạn. Vui lòng nhập vị trí tìm kiếm.');
                                }
                            );
                        }
                    } else {
                        //searchByAddress(searchLocation, hostName, radius);
                        searchSchool(searchLocation,hostName, radius)
                    }
                });


                // Hàm tìm kiếm theo vị trí hiện tại
                function searchByCurrentLocation(hostName, radius) {
                    console.log('Tìm kiếm với vị trí hiện tại, bán kính:', radius, 'km');


                    removeAllMarkers(); // Xóa tất cả marker cũ
                    addSearchLocationMarker(userLocation.lat, userLocation.lng); // Thêm marker vị trí tìm kiếm


                    const visibleCount = filterApartmentsByRadius(userLocation.lat, userLocation.lng, radius);


                    if (hostName) {
                        filterApartmentsByName(hostName);
                    }


                    map.flyTo({
                        center: [userLocation.lng, userLocation.lat],
                        zoom: getZoomLevelByRadius(radius),
                        essential: true
                    });


                    // showSearchResults(visibleCount, radius);
                    drawRadiusCircle(userLocation.lat, userLocation.lng, radius);


                    // Thêm lại marker cho các khu trọ hiển thị
                    const visibleApartments = document.querySelectorAll('.apartment-item[style*="display: block"]');
                    visibleApartments.forEach(function(apartment) {
                        const lat = parseFloat(apartment.dataset.lat);
                        const lng = parseFloat(apartment.dataset.lng);
                        const id = apartment.dataset.id;


                        if (!isNaN(lat) && !isNaN(lng)) {
                            const el = document.createElement('div');
                            el.className = 'marker';


                            const apartmentName = apartment.querySelector('.r-title').textContent;
                            const apartmentPrice = apartment.querySelector('.room-price h5').textContent;
                            const apartmentLocation = apartment.querySelector('.properties-location').textContent.trim();
                            const apartmentImg = apartment.querySelector('.property-pic img').getAttribute('src');


                            const popupContent = `
                                <div class="apartment-popup">
                                    <img src="${apartmentImg}" alt="${apartmentName}" class="apartment-popup-image">
                                    <div class="apartment-popup-title">${apartmentName}</div>
                                    <div class="apartment-popup-price">${apartmentPrice}</div>
                                    <div class="apartment-popup-address">${apartmentLocation}</div>
                                    <a href="${document.location.origin}/user/apartments/${id}" class="apartment-popup-button">Xem chi tiết</a>
                                    <button class="directions-button" data-lat="${lat}" data-lng="${lng}" data-name="${apartmentName}">
                                        <i class="fa fa-route"></i> Chỉ đường
                                    </button>
                                </div>
                            `;


                            const popup = new mapboxgl.Popup({ offset: 25 })
                                .setHTML(popupContent);


                            const marker = new mapboxgl.Marker(el)
                                .setLngLat([lng, lat])
                                .setPopup(popup)
                                .addTo(map);
                            markers.push(marker);
                        }
                    });
                }


                // Hàm tìm kiếm theo địa chỉ đã nhập (đã được chỉnh sửa)
                function searchByAddress(address, hostName, radius) {
                    console.log('Tìm kiếm với địa chỉ:', address, 'bán kính:', radius, 'km');


                    // Sử dụng Mapbox Geocoding API với types=address,poi để lấy địa chỉ cụ thể
                    fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json?access_token=${mapboxgl.accessToken}&country=VN&limit=1&types=address,poi`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.features && data.features.length > 0) {
                                // Lấy tọa độ từ feature đầu tiên (chính xác nhất)
                                const coordinates = data.features[0].center;
                                const searchLng = coordinates[0];
                                const searchLat = coordinates[1];


                                removeAllMarkers(); // Xóa tất cả marker cũ
                                addSearchLocationMarker(searchLat, searchLng); // Thêm marker vị trí tìm kiếm


                                const visibleCount = filterApartmentsByRadius(searchLat, searchLng, radius);


                                if (hostName) {
                                    filterApartmentsByName(hostName);
                                }


                                map.flyTo({
                                    center: [searchLng, searchLat],
                                    zoom: getZoomLevelByRadius(radius),
                                    essential: true
                                });


                                // showSearchResults(visibleCount, radius);
                                drawRadiusCircle(searchLat, searchLng, radius);


                                // Thêm lại marker cho các khu trọ hiển thị
                                const visibleApartments = document.querySelectorAll('.apartment-item[style*="display: block"]');
                                visibleApartments.forEach(function(apartment) {
                                    const lat = parseFloat(apartment.dataset.lat);
                                    const lng = parseFloat(apartment.dataset.lng);
                                    const id = apartment.dataset.id;


                                    if (!isNaN(lat) && !isNaN(lng)) {
                                        const el = document.createElement('div');
                                        el.className = 'marker';


                                        const apartmentName = apartment.querySelector('.r-title').textContent;
                                        const apartmentPrice = apartment.querySelector('.room-price h5').textContent;
                                        const apartmentLocation = apartment.querySelector('.properties-location').textContent.trim();
                                        const apartmentImg = apartment.querySelector('.property-pic img').getAttribute('src');


                                        const popupContent = `
                                            <div class="apartment-popup">
                                                <img src="${apartmentImg}" alt="${apartmentName}" class="apartment-popup-image">
                                                <div class="apartment-popup-title">${apartmentName}</div>
                                                <div class="apartment-popup-price">${apartmentPrice}</div>
                                                <div class="apartment-popup-address">${apartmentLocation}</div>
                                                <a href="${document.location.origin}/user/apartments/${id}" class="apartment-popup-button">Xem chi tiết</a>
                                                <button class="directions-button" data-lat="${lat}" data-lng="${lng}" data-name="${apartmentName}">
                                                    <i class="fa fa-route"></i> Chỉ đường
                                                </button>
                                            </div>
                                        `;


                                        const popup = new mapboxgl.Popup({ offset: 25 })
                                            .setHTML(popupContent);


                                        const marker = new mapboxgl.Marker(el)
                                            .setLngLat([lng, lat])
                                            .setPopup(popup)
                                            .addTo(map);
                                        markers.push(marker);
                                    }
                                });
                            } else {
                                alert('Không tìm thấy địa chỉ đã nhập. Vui lòng thử lại.');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi tìm kiếm địa chỉ:', error);
                            alert('Có lỗi xảy ra khi tìm kiếm địa chỉ. Vui lòng thử lại.');
                        });
                }


                // Hàm lọc khu trọ theo tên
                function filterApartmentsByName(hostName) {
                    const searchTerm = hostName.toLowerCase();
                    const visibleApartments = document.querySelectorAll('.apartment-item[style*="display: block"]');


                    visibleApartments.forEach(function(apartment) {
                        const title = apartment.querySelector('.r-title').textContent.toLowerCase();
                        const host = apartment.querySelector('.properties-owner').textContent.toLowerCase();


                        if (!title.includes(searchTerm) && !host.includes(searchTerm)) {
                            apartment.style.display = 'none';
                        }
                    });
                }


                // Hàm tính mức zoom phù hợp với bán kính
                function getZoomLevelByRadius(radius) {
                    if (radius <= 1) return 15;
                    if (radius <= 2) return 14;
                    if (radius <= 5) return 13;
                    if (radius <= 10) return 12;
                    if (radius <= 20) return 11;
                    return 10;
                }


                // Hàm hiển thị kết quả tìm kiếm
                function showSearchResults(count, radius) {
                    const resultMessage = `Tìm thấy ${count} khu trọ trong bán kính ${radius} km.`;
                    let resultElement = document.querySelector('.search-results-message');
                    if (!resultElement) {
                        resultElement = document.createElement('div');
                        resultElement.className = 'search-results-message alert alert-info mt-3';
                        document.querySelector('.property-title').after(resultElement);
                    }
                    resultElement.textContent = resultMessage;
                }


                // Hàm vẽ vòng tròn bán kính tìm kiếm
                function drawRadiusCircle(lat, lng, radiusKm) {
                    if (map.getSource('radius-circle')) {
                        map.removeLayer('radius-circle-layer');
                        map.removeSource('radius-circle');
                    }


                    const center = [lng, lat];
                    const options = {steps: 64, units: 'kilometers'};
                    const circle = turf.circle(center, radiusKm, options);


                    map.addSource('radius-circle', {
                        'type': 'geojson',
                        'data': circle
                    });


                    map.addLayer({
                        'id': 'radius-circle-layer',
                        'type': 'fill',
                        'source': 'radius-circle',
                        'paint': {
                            'fill-color': '#3498db',
                            'fill-opacity': 0.1,
                            'fill-outline-color': '#3498db'
                        }
                    });
                }
 


                function searchSchool(schoolName,hostName, radius) {
                fetch(`{{ route('school.search') }}?search_location=${encodeURIComponent(schoolName)}&radius=${radius}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const school = data.school;
                            const apartments = data.apartments;
                            const longitude = Number(school.GPS_Longitude);
                            const latitude = Number(school.GPS_Latitude);
                            schoolLocation = {
                                lat: Number(school.GPS_Latitude),
                                lng: Number(school.GPS_Longitude)
                            };


                            removeAllMarkers();
                         
                            //Hiển thị marker cho trường học
                           
                            const schoolMarker = new mapboxgl.Marker()
                                .setLngLat([longitude, latitude])
                                .setPopup(new mapboxgl.Popup().setHTML(`<b>${school.name}</b>`))
                                .addTo(map);
                            markers.push(schoolMarker);


                            // Di chuyển bản đồ đến vị trí trường học
                            map.flyTo({
                                center: [school.GPS_Longitude, school.GPS_Latitude],
                                zoom: 12
                            });
                           
                            drawRadiusCircle(school.GPS_Latitude, school.GPS_Longitude, radius);
                            // Lọc và hiển thị các khu trọ trong danh sách
                            const apartmentItems = document.querySelectorAll('.apartment-item');
                            apartmentItems.forEach(function(apartment) {
                                const apartmentId = apartment.dataset.id;
                                if (apartments.some(apt => apt.id == apartmentId)) {
                                    apartment.style.display = 'block';
                                } else {
                                    apartment.style.display = 'none';
                                }
                            });
                           
                            if (hostName) {
                                filterApartmentsByName(hostName);
                            }
                            const visibleApartments = Array.from(apartmentItems).filter(apartment => apartment.style.display !== 'none');
                           
                            visibleApartments.forEach(function(apartmentElement) {
                            const apartmentId = apartmentElement.dataset.id;
                            const apartment = apartments.find(apt => apt.id == apartmentId);
                            if (apartment) {
                                const lat = apartment.GPS_Latitude;
                                const lng = apartment.GPS_Longitude;
                                const id = apartment.id;
                               
                                const el = document.createElement('div');
                                el.className = 'marker';
                               
                                const popupContent = `
                                    <div class="apartment-popup">
                                        <img src="${apartment.image}" alt="${apartment.name}" class="apartment-popup-image">
                                        <div class="apartment-popup-title">${apartment.name}</div>
                                        <div class="apartment-popup-price">${apartment.minPrice} VNĐ/tháng</div>
                                        <div class="apartment-popup-address">${apartment.location}</div>
                                        <a href="${document.location.origin}/user/apartments/${id}" class="apartment-popup-button">Xem chi tiết</a>
                                        <button class="directions-button" data-lat="${lat}" data-lng="${lng}" data-name="${apartment.name}">
                                            <i class="fa fa-route"></i> Chỉ đường
                                        </button>
                                    </div>
                                `;
                               
                                const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(popupContent);
                                const marker = new mapboxgl.Marker(el)
                                    .setLngLat([lng, lat])
                                    .setPopup(popup)
                                    .addTo(map);
                                markers.push(marker);
                            }
                        });
                           
                           
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error searching for school:', error);
                        alert('Lỗi tìm kiếm trường.');
                    });
            }


           




            } catch (error) {
                console.error('Error initializing map:', error);
                const mapElement = document.getElementById('apartmentMap');
                if (mapElement) {
                    mapElement.innerHTML = '<p class="text-center">Không thể tải bản đồ: ' + error.message + '</p>';
                }
            }
        }




        let schoolLocation = null;
        function showDirections(destLat, destLng, destName) {
            console.log('Hiển thị chỉ đường đến:', destName, destLat, destLng);


            // Hiển thị directions container
            document.getElementById('directions-container').style.display = 'block';
            directions.setDestination([destLng, destLat]);


            // Kiểm tra nếu có tọa độ trường học
            if (schoolLocation) {
                // Nếu có tọa độ trường học, sử dụng trường học làm điểm xuất phát
                console.log("Sử dụng trường học làm điểm xuất phát");
                directions.setOrigin([schoolLocation.lng, schoolLocation.lat]);
            } else if (userLocation) {
                // Nếu không có trường học, dùng vị trí người dùng làm điểm xuất phát
                console.log("Sử dụng vị trí người dùng làm điểm xuất phát");
                directions.setOrigin([userLocation.lng, userLocation.lat]);
            } else {
                // Nếu không có cả vị trí trường và người dùng, yêu cầu người dùng nhập vị trí
                alert('Vui lòng nhập vị trí xuất phát hoặc cho phép truy cập vị trí của bạn.');
                directions.setOrigin(''); // Xóa điểm xuất phát nếu không có gì


                // Sử dụng Geolocation API để lấy vị trí người dùng nếu chưa có
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        userLocation = {
                            lng: position.coords.longitude,
                            lat: position.coords.latitude
                        };
                        directions.setOrigin([userLocation.lng, userLocation.lat]);
                    },
                    function(error) {
                        console.error('Lỗi lấy vị trí người dùng:', error);
                    }
                );
            }
        }






        function hideDirections() {
            document.getElementById('directions-container').style.display = 'none';
            directions.removeRoutes();
        }


       


       
    </script>
@endsection
