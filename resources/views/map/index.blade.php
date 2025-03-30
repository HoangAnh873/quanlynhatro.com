@extends('adminlte::page')

@section('title', 'Bản đồ Cần Thơ')

@section('content')
    {{-- <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tỷ lệ phân bố khu trọ theo xã tại Cần Thơ</h3>
        </div> --}}
        <div class="card-body">
            <div id="map" style="height: 500px;"></div>
        </div>
    </div>
@stop

@push('css')
<link href="https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.css" rel="stylesheet" />
<style>
    .mapboxgl-popup {
        max-width: 300px;
    }
    .mapboxgl-popup-content {
        padding: 15px;
    }
    .loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255,255,255,0.8);
        padding: 20px;
        border-radius: 5px;
        z-index: 999;
    }
</style>
@endpush

@push('js')
<script src="https://api.mapbox.com/mapbox-gl-js/v2.12.0/mapbox-gl.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Thêm loading indicator
        const loadingElement = document.createElement('div');
        loadingElement.className = 'loading';
        loadingElement.innerHTML = '<h3>Đang tải dữ liệu...</h3>';
        document.querySelector('#map').appendChild(loadingElement);
        
        // Thêm access token của Mapbox
        const mapboxAccessToken = 'pk.eyJ1IjoiaG9hbmdhbmhoaCIsImEiOiJjbTg2NXlxbXYwMWRzMmpxeHZxODJ0b2Q1In0.37CjmObFMH_1B04-QE6MtQ';

        // Khởi tạo bản đồ với Mapbox GL JS (trung tâm Cần Thơ)
        mapboxgl.accessToken = mapboxAccessToken;
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [105.7469, 10.0452],
            zoom: 12
        });

        // Dữ liệu khu trọ từ backend
        const apartments = @json($apartments);
        
        // Dữ liệu các xã từ backend
        const wards = @json($wards);
        
        // Đợi bản đồ load xong
        map.on('load', function() {
            // Loại bỏ loading indicator
            const loadingElement = document.querySelector('.loading');
            if (loadingElement) {
                loadingElement.remove();
            }
            
            // Chắc chắn mỗi feature đều có một ID duy nhất
            wards.forEach((ward, index) => {
                if (!ward.id) {
                    ward.id = index + 1;
                }
                
                // Khởi tạo count = 0 cho mỗi xã
                if (!ward.properties) {
                    ward.properties = {};
                }
                ward.properties.count = 0;
            });
            
            // Đếm số lượng khu trọ trong mỗi xã
            apartments.forEach(apt => {
                if (apt.latitude && apt.longitude) {
                    const point = [parseFloat(apt.longitude), parseFloat(apt.latitude)];
                    
                    // Thêm thư viện Turf.js để kiểm tra điểm nằm trong polygon
                    if (typeof turf !== 'undefined') {
                        const pt = turf.point(point);
                        
                        wards.forEach(ward => {
                            try {
                                if (turf.booleanPointInPolygon(pt, ward.geometry)) {
                                    ward.properties.count++;
                                }
                            } catch (e) {
                                console.error("Lỗi khi kiểm tra điểm trong polygon:", e);
                            }
                        });
                    } else {
                        // Nếu không có Turf.js, sử dụng hàm kiểm tra thủ công
                        wards.forEach(ward => {
                            if (isPointInPolygon(point, ward)) {
                                ward.properties.count++;
                            }
                        });
                    }
                }
            });
            
            // Log số lượng trọ trong mỗi xã để kiểm tra
            console.log("Số lượng khu trọ trong mỗi xã:", wards.map(w => ({
                name: w.properties.name,
                count: w.properties.count
            })));
            
            // Tạo GeoJSON cho tất cả các xã
            const wardsGeoJSON = {
                type: 'FeatureCollection',
                features: wards
            };
            
            // Thêm source cho các xã
            map.addSource('wards-source', {
                type: 'geojson',
                data: wardsGeoJSON
            });
            
            // Thêm layer cho các xã
            map.addLayer({
                id: 'wards-layer',
                type: 'fill',
                source: 'wards-source',
                layout: {},
                paint: {
                    'fill-color': [
                        'step',
                        ['get', 'count'],
                        '#FFFBF0',   // 0-2 khu trọ
                        2, '#FED976', // 2-5 khu trọ
                        5, '#FD8D3C', // 5-10 khu trọ
                        10, '#FC4E2A', // 10-20 khu trọ
                        20, '#E31A1C', // 20+ khu trọ
                        
                    ],
                    'fill-opacity': 0.7
                }
            });
            
            // Thêm layer cho viền các xã
            map.addLayer({
                id: 'wards-outline',
                type: 'line',
                source: 'wards-source',
                layout: {},
                paint: {
                    'line-color': '#000',
                    'line-width': 1
                }
            });
            
            // Thêm layer cho hiệu ứng hover
            map.addLayer({
                id: 'wards-hover',
                type: 'line',
                source: 'wards-source',
                layout: {},
                paint: {
                    'line-color': '#FFFFFF',
                    'line-width': [
                        'case',
                        ['boolean', ['feature-state', 'hover'], false],
                        3,
                        0
                    ]
                }
            });
            
            // Thêm marker cho các khu trọ
            apartments.forEach(apt => {
                if (apt.latitude && apt.longitude) {
                    new mapboxgl.Marker({ color: "#FF0000", scale: 0.7 })
                        .setLngLat([parseFloat(apt.longitude), parseFloat(apt.latitude)])
                        .setPopup(new mapboxgl.Popup().setHTML(`
                            <div>
                                <h4>Thông tin khu trọ</h4>
                                <p>Tên: ${apt.name || 'Không có tên'}</p>
                                <p>Địa chỉ: ${apt.address || 'Không có địa chỉ'}</p>
                            </div>
                        `))
                        .addTo(map);
                }
            });
            
            // Xử lý hiệu ứng hover
            let hoveredStateId = null;
            
            map.on('mousemove', 'wards-layer', (e) => {
                if (e.features.length > 0) {
                    if (hoveredStateId !== null) {
                        map.setFeatureState(
                            { source: 'wards-source', id: hoveredStateId },
                            { hover: false }
                        );
                    }
                    hoveredStateId = e.features[0].id;
                    map.setFeatureState(
                        { source: 'wards-source', id: hoveredStateId },
                        { hover: true }
                    );
                }
            });
            
            map.on('mouseleave', 'wards-layer', () => {
                if (hoveredStateId !== null) {
                    map.setFeatureState(
                        { source: 'wards-source', id: hoveredStateId },
                        { hover: false }
                    );
                }
                hoveredStateId = null;
            });
            
            // Thêm tương tác khi click vào xã
            map.on('click', 'wards-layer', function(e) {
                if (e.features.length > 0) {
                    const feature = e.features[0];
                    new mapboxgl.Popup()
                        .setLngLat(e.lngLat)
                        .setHTML(`
                            <div>
                                <h4>${feature.properties.name || 'Không xác định'}</h4>
                                <p>Số khu trọ: ${feature.properties.count || 0}</p>
                            </div>
                        `)
                        .addTo(map);
                }
            });
            
            // Thay đổi con trỏ khi di chuột qua xã
            map.on('mouseenter', 'wards-layer', function() {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'wards-layer', function() {
                map.getCanvas().style.cursor = '';
            });
            
            // Thêm chú thích
            const legend = document.createElement('div');
            legend.className = 'legend';
            legend.style.position = 'absolute';
            legend.style.bottom = '20px';
            legend.style.right = '20px';
            legend.style.background = 'rgba(255, 255, 255, 0.9)';
            legend.style.padding = '10px';
            legend.style.borderRadius = '5px';
            legend.style.boxShadow = '0 1px 5px rgba(0, 0, 0, 0.4)';

            legend.innerHTML = `
                <h4 style="margin-top: 0; margin-bottom: 8px;">Số lượng khu trọ</h4>
                <div><i style="background: #FFFBF0; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>0 - 2</div>
                <div><i style="background: #FED976; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>2 - 5</div>
                <div><i style="background: #FD8D3C; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>5 - 10</div>
                <div><i style="background: #FC4E2A; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>10 - 20</div>
                <div><i style="background: #E31A1C; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>20+</div>
            `;

            map.getContainer().appendChild(legend);
        });
        
        // Tải thư viện Turf.js
        function loadTurfJS() {
            if (typeof turf !== 'undefined') {
                return Promise.resolve();
            }
            
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/@turf/turf@6/turf.min.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }
        
        // Hàm kiểm tra điểm có nằm trong polygon không - cài đặt thủ công nếu không có Turf.js
        function isPointInPolygon(point, feature) {
            const geometry = feature.geometry;
            if (!geometry) return false;
            
            if (geometry.type === 'Polygon') {
                // Polygon có thể có nhiều vòng, vòng đầu tiên là outline
                return pointInSinglePolygon(point, geometry.coordinates[0]);
            } else if (geometry.type === 'MultiPolygon') {
                // Kiểm tra từng polygon trong multipolygon
                for (const polygon of geometry.coordinates) {
                    if (pointInSinglePolygon(point, polygon[0])) {
                        return true;
                    }
                }
            }
            return false;
        }
        
        function pointInSinglePolygon(point, polygon) {
            const x = point[0], y = point[1];
            let inside = false;
            
            for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
                const xi = polygon[i][0], yi = polygon[i][1];
                const xj = polygon[j][0], yj = polygon[j][1];
                
                const intersect = ((yi > y) !== (yj > y)) &&
                    (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                    
                if (intersect) inside = !inside;
            }
            
            return inside;
        }
        
        // Tải thư viện Turf.js nếu cần
        loadTurfJS().then(() => {
            console.log('Đã tải thư viện Turf.js thành công');
        }).catch(() => {
            console.warn('Không thể tải thư viện Turf.js, sẽ sử dụng phương pháp thủ công');
        });
    });
</script>
@endpush