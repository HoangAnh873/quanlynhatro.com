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
        zoom: 11
    });

    // Dữ liệu khu trọ từ backend
    const apartments = @json($apartments);
    
    // Đợi bản đồ load xong
    map.on('load', function() {
        // Kiểm tra nếu có dữ liệu từ controller
        let wards = @json($wards);
        
        // Nếu không có dữ liệu từ controller, tải dữ liệu từ Overpass API
        if (!wards || wards.length === 0) {
            fetchWardsFromOverpass();
        } else {
            processData(wards);
        }
    });

    // Hàm lấy dữ liệu từ Overpass API (client-side)
    function fetchWardsFromOverpass() {
        const overpassUrl = "https://overpass-api.de/api/interpreter";
        const query = `
            [out:json];
            area["name"="Cần Thơ"]["admin_level"="4"]->.cantho;
            rel(area.cantho)["admin_level"="9"]["boundary"="administrative"];
            out geom;
        `;

        fetch(overpassUrl, {
            method: 'POST',
            body: query
        })
        .then(response => response.json())
        .then(data => {
            const wards = [];
            
            if (data.elements) {
                data.elements.forEach(element => {
                    if (element.type === 'relation' && element.tags && element.tags.name) {
                        // Chuyển đổi dữ liệu sang dạng GeoJSON
                        const geojson = convertToGeoJSON(element);
                        if (geojson) {
                            wards.push(geojson);
                        }
                    }
                });
            }
            
            processData(wards);
        })
        .catch(error => {
            console.error("Lỗi khi lấy dữ liệu từ Overpass API:", error);
            document.querySelector('.loading').innerHTML = '<h3>Lỗi khi tải dữ liệu</h3>';
        });
    }

    // Hàm chuyển đổi dữ liệu sang dạng GeoJSON
    function convertToGeoJSON(element) {
        if (!element.members || element.members.length === 0) {
            return null;
        }

        // Tạo polygon từ các thành phần
        const polygons = [];
        let ways = {};
        let outerWays = [];
        let innerWays = [];
        
        // Xác định các way và phân loại outer/inner
        element.members.forEach(member => {
            if (member.type === 'way' && member.geometry) {
                ways[member.ref] = member.geometry.map(point => [point.lon, point.lat]);
                
                if (member.role === 'outer') {
                    outerWays.push(member.ref);
                } else if (member.role === 'inner') {
                    innerWays.push(member.ref);
                }
            }
        });
        
        // Nếu không có phân loại role, coi tất cả là outer
        if (outerWays.length === 0 && Object.keys(ways).length > 0) {
            outerWays = Object.keys(ways);
        }
        
        // Tạo polygon cho mỗi outer way
        outerWays.forEach(wayId => {
            const outerRing = ways[wayId];
            if (outerRing && outerRing.length > 0) {
                // Tìm các inner way liên quan
                const holes = innerWays.map(innerWayId => ways[innerWayId]).filter(Boolean);
                
                // Tạo polygon với outer ring và các inner rings
                const polygon = [outerRing, ...holes];
                polygons.push(polygon);
            }
        });
        
        if (polygons.length === 0) {
            return null;
        }

        // Tạo đối tượng GeoJSON
        return {
            type: 'Feature',
            id: element.id,
            properties: {
                name: element.tags.name || 'Không xác định',
                count: 0
            },
            geometry: {
                type: polygons.length === 1 ? 'Polygon' : 'MultiPolygon',
                coordinates: polygons.length === 1 ? polygons[0] : polygons
            }
        };
    }

    // Hàm xử lý dữ liệu
    function processData(wards) {
        // Xóa loading indicator
        const loadingElement = document.querySelector('.loading');
        if (loadingElement) {
            loadingElement.remove();
        }
        
        // Tạo GeoJSON cho tất cả các xã
        const wardsGeoJSON = {
            type: 'FeatureCollection',
            features: wards
        };
        
        // Đếm số lượng khu trọ trong mỗi xã
        countApartmentsInWards(wards, apartments);
        
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
            paint: {
                'fill-color': [
                    'step',
                    ['get', 'count'],
                    '#FFEDA0',    // 0-5
                    5, '#FD8D3C', // 5-10
                    10, '#FC4E2A', // 10-15
                    15, '#E31A1C', // 15-20
                    20, '#BD0026', // 20-25
                    25, '#800026'  // 25+
                ],
                'fill-opacity': 0.7
            }
        });
        
        // Thêm layer cho viền các xã
        map.addLayer({
            id: 'wards-outline',
            type: 'line',
            source: 'wards-source',
            paint: {
                'line-color': '#000',
                'line-width': 1
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
                            <p>Vị trí: ${apt.latitude}, ${apt.longitude}</p>
                        </div>
                    `))
                    .addTo(map);
            }
        });
        
        // Thêm tương tác khi click vào xã
        map.on('click', 'wards-layer', function(e) {
            if (e.features.length > 0) {
                const feature = e.features[0];
                new mapboxgl.Popup()
                    .setLngLat(e.lngLat)
                    .setHTML(`
                        <div>
                            <h4>${feature.properties.name}</h4>
                            <p>Số khu trọ: ${feature.properties.count}</p>
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
            <div><i style="background: #FFEDA0; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>0 - 5</div>
            <div><i style="background: #FD8D3C; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>5 - 10</div>
            <div><i style="background: #FC4E2A; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>10 - 15</div>
            <div><i style="background: #E31A1C; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>15 - 20</div>
            <div><i style="background: #BD0026; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>20 - 25</div>
            <div><i style="background: #800026; width: 18px; height: 18px; float: left; margin-right: 8px; border: 1px solid #ccc;"></i>25+</div>
        `;

        map.getContainer().appendChild(legend);
    }
    
    // Hàm đếm số lượng khu trọ trong mỗi xã - cải tiến
    function countApartmentsInWards(wards, apartments) {
        apartments.forEach(apt => {
            if (apt.latitude && apt.longitude) {
                const point = [parseFloat(apt.longitude), parseFloat(apt.latitude)];
                
                // Sử dụng thư viện Turf.js nếu có
                if (typeof turf !== 'undefined') {
                    const pt = turf.point(point);
                    
                    wards.forEach(ward => {
                        try {
                            // Kiểm tra điểm nằm trong polygon
                            if (turf.booleanPointInPolygon(pt, ward.geometry)) {
                                ward.properties.count++;
                            }
                        } catch (e) {
                            console.error("Lỗi khi kiểm tra điểm trong polygon:", e);
                        }
                    });
                } else {
                    // Thực hiện kiểm tra thủ công nếu không có Turf.js
                    wards.forEach(ward => {
                        if (isPointInPolygon(point, ward)) {
                            ward.properties.count++;
                        }
                    });
                }
            }
        });
        
        // Log số lượng khu trọ trong mỗi xã để kiểm tra
        console.log("Số lượng khu trọ trong mỗi xã:", wards.map(w => ({
            name: w.properties.name,
            count: w.properties.count
        })));
    }
    
    // Hàm kiểm tra điểm có nằm trong polygon không - cải tiến
    function isPointInPolygon(point, feature) {
        // Xử lý các loại geometry khác nhau
        const geometry = feature.geometry;
        if (!geometry) return false;
        
        if (geometry.type === 'Polygon') {
            return pointInPolygon(point, geometry.coordinates[0]);
        } else if (geometry.type === 'MultiPolygon') {
            // Kiểm tra từng polygon trong multipolygon
            for (let i = 0; i < geometry.coordinates.length; i++) {
                if (pointInPolygon(point, geometry.coordinates[i][0])) {
                    return true;
                }
            }
        }
        return false;
    }
    
    // Hàm kiểm tra điểm nằm trong một polygon đơn
    function pointInPolygon(point, polygon) {
        const x = point[0], y = point[1];
        let inside = false;
        
        for (let i = 0, j = polygon.length - 1; i < polygon.length; j = i++) {
            const xi = polygon[i][0], yi = polygon[i][1];
            const xj = polygon[j][0], yj = polygon[j][1];
            
            // Kiểm tra giao điểm theo thuật toán ray casting
            const intersect = ((yi > y) !== (yj > y)) &&
                (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                
            if (intersect) {
                inside = !inside;
            }
        }
        
        return inside;
    }
    
    // Tải và thêm thư viện Turf.js nếu cần thiết
    function loadTurfJS() {
        return new Promise((resolve, reject) => {
            if (typeof turf !== 'undefined') {
                resolve();
                return;
            }
            
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js';
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    
    // Cố gắng tải Turf.js cho phân tích không gian tốt hơn
    loadTurfJS().then(() => {
        console.log('Đã tải thư viện Turf.js thành công');
    }).catch(() => {
        console.warn('Không thể tải thư viện Turf.js, sẽ sử dụng phương pháp thủ công');
    });
});
</script>
@endpush