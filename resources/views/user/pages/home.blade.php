{{-- home.blade.php --}}
@extends('user.layouts.master')

@section('title', 'Trang Chủ')

@section('content')

    <!-- Phần Banner Bắt Đầu -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-item set-bg" data-setbg="img/hero/hero4.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="hero-text">
                                {{-- <p class="room-location"><i class="icon_pin"></i> 123 Đường 3/2, Ninh Kiều, Cần Thơ</p> --}}
                                <h2>Phòng trọ tiện nghi trung tâm Cần Thơ</h2>
                                <div class="room-price">
                                    <span>Giá thuê từ:</span>
                                    <p>1.000.000 VNĐ/tháng</p>
                                </div>
                                <ul class="room-features list-unstyled d-flex justify-content-around">
                                    <li class="text-center">
                                        <i class="fa fa-arrows mb-2"></i>
                                        <p>20m²</p>
                                    </li>
                                    <li class="text-center">
                                        <i class="fa fa-bed mb-2"></i>
                                        <p>1 giường</p>
                                    </li>
                                    <li class="text-center">
                                        <i class="fa fa-bath mb-2"></i>
                                        <p>1 phòng tắm</p>
                                    </li>
                                    <li class="text-center">
                                        <i class="fa fa-wifi mb-2"></i>
                                        <p>Wi-Fi miễn phí</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="single-hero-item set-bg" data-setbg="img/hero/hero5.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="hero-text">
                                <p class="room-location"><i class="icon_pin"></i> 456 Đường Nguyễn Văn Cừ, Ninh Kiều, Cần Thơ</p>
                                <h2>Phòng trọ cao cấp gần Đại học Cần Thơ</h2>
                                <div class="room-price">
                                    <span>Giá thuê từ:</span>
                                    <p>2.000.000 VNĐ/tháng</p>
                                </div>
                                <ul class="room-features">
                                    <li>
                                        <i class="fa fa-arrows"></i>
                                        <p>25m²</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-bed"></i>
                                        <p>1 giường</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-bath"></i>
                                        <p>1 phòng tắm</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-car"></i>
                                        <p>Chỗ đậu xe</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-hero-item set-bg" data-setbg="img/hero/hero6.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="hero-text">
                                <p class="room-location"><i class="icon_pin"></i> 789 Đường Mậu Thân, Ninh Kiều, Cần Thơ</p>
                                <h2>Phòng trọ đầy đủ tiện nghi, gần Vincom</h2>
                                <div class="room-price">
                                    <span>Giá thuê từ:</span>
                                    <p>3.00.000 VNĐ/tháng</p>
                                </div>
                                <ul class="room-features">
                                    <li>
                                        <i class="fa fa-arrows"></i>
                                        <p>22m²</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-bed"></i>
                                        <p>1 giường</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-bath"></i>
                                        <p>1 phòng tắm</p>
                                    </li>
                                    <li>
                                        <i class="fa fa-wifi"></i>
                                        <p>Internet miễn phí</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>

        {{-- <div class="thumbnail-pic">
            <div class="thumbs owl-carousel">
                <div class="item">
                    <img src="img/hero/dot-1.jpg" alt="">
                </div>
                <div class="item">
                    <img src="img/hero/dot-2.jpg" alt="">
                </div>
                <div class="item">
                    <img src="img/hero/dot-3.jpg" alt="">
                </div>
            </div>
        </div> --}}

    </section>
    <!-- Phần Banner Kết Thúc -->

    <!-- Phần Cách Hoạt Động Bắt Đầu -->
    <section class="howit-works spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tìm Nhà Trọ Mơ Ước Của Bạn</span>
                        <h2>Cách Hoạt Động</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-howit-works">
                        <img src="img/howit-works/howit-works-1.png" alt="">
                        <h4>Tìm Kiếm & Khám Phá Nhà Trọ</h4>
                        <p>Sử dụng bộ lọc để tìm kiếm phòng trọ theo số người, giá cả, vị trí và tiện nghi.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-howit-works">
                        <img src="img/howit-works/howit-works-2.png" alt="">
                        <h4>Chọn Phòng Phù Hợp</h4>
                        <p>Xem chi tiết phòng trọ, hình ảnh, đánh giá và chọn phòng phù hợp với nhu cầu.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-howit-works">
                        <img src="img/howit-works/howit-works-3.png" alt="">
                        <h4>Liên Hệ Với Chủ Trọ</h4>
                        <p>Gửi yêu cầu thuê phòng, liên hệ với chủ trọ và hoàn tất thủ tục đặt phòng nhanh chóng.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Phần Cách Hoạt Động Kết Thúc -->

    <!-- Phần Tìm Kiếm Phòng Trọ Bắt Đầu -->
    <div class="search-form py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="search-header text-center bg-info text-white py-3 rounded-top">
                        <h4 class="mb-0">
                            <i class="fa fa-search me-2"></i>
                            TÌM KIẾM PHÒNG TRỌ
                        </h4>
                        <p class="mt-2 mb-0">Nhập thông tin để tìm phòng trọ phù hợp với nhu cầu của bạn</p>
                    </div>
                    
                    <div class="search-body bg-white p-4 rounded-bottom shadow">
                        <form action="{{ route('user.rooms.search') }}" method="GET" class="filter-form" id="searchForm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Số người ở</label>
                                        <select name="num_people" id="numPeople" class="form-select">
                                            <option value="">Chọn số người</option>
                                            <option value="1">1 người</option>
                                            <option value="2">2 người</option>
                                            <option value="3">3 người</option>
                                            <option value="4">4 người trở lên</option>
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Mức giá</label>
                                        <select name="price" id="price" class="form-select">
                                            <option value="">Chọn mức giá</option>
                                            <option value="1000000">Dưới 1 triệu</option>
                                            <option value="1500000">Dưới 1.5 triệu</option>
                                            <option value="2000000">Dưới 2 triệu</option>
                                            <option value="2000001">Trên 2 triệu</option>
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Ngày nhận phòng</label>
                                        <input type="date" name="check_in_date" class="form-control" id="checkInDate">
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Thời gian thuê</label>
                                        <select name="duration" id="duration" class="form-select">
                                            <option value="1">1 tháng</option>
                                            <option value="3">3 tháng</option>
                                            <option value="6">6 tháng</option>
                                            <option value="12">12 tháng</option>
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Vị trí của bạn</label>
                                        <input type="text" name="location" id="locationInput" class="form-control" placeholder="Nhập địa chỉ hoặc để trống để lấy vị trí hiện tại">
                                        <small class="text-muted">Ví dụ: Cần Thơ, Việt Nam</small>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Bán kính (km)</label>
                                        <input type="number" name="radius" min="1" max="50" class="form-control" value="5">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Trường ẩn để chứa tọa độ nếu lấy vị trí tự động -->
                            <input type="hidden" name="latitude" id="latitudeInput">
                            <input type="hidden" name="longitude" id="longitudeInput">
                        
                            <div class="text-center mt-4">
                                <button type="submit" class="search-btn btn btn-primary px-5 py-2 fw-bold">
                                    <i class="fa fa-search me-2"></i>Tìm kiếm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Phần Tìm Kiếm Phòng Trọ Kết Thúc -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Phần xử lý ngày nhận và trả phòng
            const checkInDateInput = document.getElementById('checkInDate');
            const durationSelect = document.getElementById('duration');
            const searchForm = document.getElementById('searchForm');
            const locationInput = document.getElementById('locationInput');
            const latitudeInput = document.getElementById('latitudeInput');
            const longitudeInput = document.getElementById('longitudeInput');

            // Thiết lập ngày mặc định là ngày hiện tại
            const today = new Date();
            checkInDateInput.value = today.toISOString().split('T')[0];

            // Tính toán ngày trả phòng ngay khi trang được tải
            calculateEndDate();

            // Gán sự kiện để cập nhật ngày trả phòng
            durationSelect.addEventListener('change', calculateEndDate);
            checkInDateInput.addEventListener('change', calculateEndDate);

            function calculateEndDate() {
                const checkInDate = new Date(checkInDateInput.value);
                if (!isNaN(checkInDate.getTime())) {
                    const months = parseInt(durationSelect.value);
                    checkInDate.setMonth(checkInDate.getMonth() + months);
                }
            }

            // Hàm lấy vị trí hiện tại - chỉ gọi khi cần thiết
            function getCurrentLocation() {
                return new Promise((resolve, reject) => {
                    if (navigator.geolocation) {
                        // Hiển thị trạng thái đang xác định vị trí
                        const loadingStatus = document.createElement('div');
                        loadingStatus.id = 'location-loading';
                        loadingStatus.className = 'alert alert-info mt-2';
                        loadingStatus.textContent = 'Đang xác định vị trí của bạn...';
                        locationInput.parentNode.appendChild(loadingStatus);
                        
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                // Tăng độ chính xác bằng cách làm tròn đến 6 chữ số thập phân
                                latitudeInput.value = position.coords.latitude.toFixed(6);
                                longitudeInput.value = position.coords.longitude.toFixed(6);
                                
                                document.getElementById('location-loading').remove();
                                const locationStatus = document.createElement('div');
                                locationStatus.className = 'alert alert-success mt-2';
                                locationStatus.textContent = 'Đã xác định được vị trí hiện tại';
                                locationInput.parentNode.appendChild(locationStatus);
                                
                                setTimeout(() => locationStatus.remove(), 3000);
                                resolve(true);
                            },
                            function(error) {
                                if (document.getElementById('location-loading')) {
                                    document.getElementById('location-loading').remove();
                                }
                                
                                const locationStatus = document.createElement('div');
                                locationStatus.className = 'alert alert-warning mt-2';
                                locationStatus.textContent = 'Không thể lấy vị trí tự động. Vui lòng nhập địa chỉ của bạn.';
                                locationInput.parentNode.appendChild(locationStatus);
                                
                                setTimeout(() => locationStatus.remove(), 5000);
                                reject(error);
                            },
                            {
                                enableHighAccuracy: true,
                                timeout: 20000, // Tăng timeout lên 20 giây
                                maximumAge: 0
                            }
                        );
                    } else {
                        const locationStatus = document.createElement('div');
                        locationStatus.className = 'alert alert-warning mt-2';
                        locationStatus.textContent = 'Trình duyệt không hỗ trợ định vị. Vui lòng nhập địa chỉ của bạn.';
                        locationInput.parentNode.appendChild(locationStatus);
                        
                        setTimeout(() => locationStatus.remove(), 5000);
                        reject(new Error("Trình duyệt không hỗ trợ Geolocation"));
                    }
                });
            }

            // Xử lý khi người dùng nhập địa chỉ
            locationInput.addEventListener('change', function() {
                if (this.value.trim() !== '') {
                    // Nếu người dùng đã nhập địa chỉ, chuyển đổi thành tọa độ
                    geocodeAddress(this.value);
                } else {
                    // Nếu người dùng xóa trống ô nhập, xóa cả tọa độ
                    latitudeInput.value = '';
                    longitudeInput.value = '';
                }
            });

            // Hàm chuyển đổi địa chỉ thành tọa độ (cần tích hợp với API)
            let lastGeocodeTime = 0;
            function geocodeAddress(address) {
                // Kiểm tra và giới hạn tần suất gọi API
                const now = Date.now();
                if (now - lastGeocodeTime < 1000) { // Đảm bảo cách nhau ít nhất 1 giây
                    setTimeout(() => geocodeAddress(address), 1000 - (now - lastGeocodeTime));
                    return;
                }
                lastGeocodeTime = now;
                
                // Hiển thị trạng thái đang tìm kiếm
                const loadingStatus = document.createElement('div');
                loadingStatus.id = 'geocode-loading';
                loadingStatus.className = 'alert alert-info mt-2';
                loadingStatus.textContent = 'Đang tìm kiếm địa chỉ...';
                locationInput.parentNode.appendChild(loadingStatus);
                
                // Thêm tham số ngôn ngữ tiếng Việt và vùng tìm kiếm
                const nominatimUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1&accept-language=vi&countrycodes=vn`;
                
                fetch(nominatimUrl)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('geocode-loading').remove();
                        if (data && data.length > 0) {
                            const { lat, lon } = data[0];
                            latitudeInput.value = lat;
                            longitudeInput.value = lon;
                            
                            const geocodeStatus = document.createElement('div');
                            geocodeStatus.className = 'alert alert-success mt-2';
                            geocodeStatus.textContent = 'Đã xác định được vị trí từ địa chỉ';
                            locationInput.parentNode.appendChild(geocodeStatus);
                            
                            setTimeout(() => geocodeStatus.remove(), 3000);
                        } else {
                            const geocodeStatus = document.createElement('div');
                            geocodeStatus.className = 'alert alert-danger mt-2';
                            geocodeStatus.textContent = 'Không tìm thấy địa chỉ. Vui lòng thử với địa chỉ chi tiết hơn.';
                            locationInput.parentNode.appendChild(geocodeStatus);
                            
                            setTimeout(() => geocodeStatus.remove(), 5000);
                        }
                    })
                    .catch(error => {
                        if (document.getElementById('geocode-loading')) {
                            document.getElementById('geocode-loading').remove();
                        }
                        console.error("Lỗi khi tìm kiếm địa chỉ:", error);
                        const geocodeStatus = document.createElement('div');
                        geocodeStatus.className = 'alert alert-danger mt-2';
                        geocodeStatus.textContent = 'Có lỗi xảy ra khi tìm kiếm địa chỉ. Vui lòng thử lại sau.';
                        locationInput.parentNode.appendChild(geocodeStatus);
                        
                        setTimeout(() => geocodeStatus.remove(), 5000);
                    });
            }

            // Kiểm tra trước khi submit form
            searchForm.addEventListener('submit', async function(e) {
                e.preventDefault(); // Ngăn form submit mặc định
                
                // Trường hợp 1: Người dùng đã nhập địa chỉ nhưng chưa chuyển đổi thành tọa độ
                if (locationInput.value.trim() !== '' && (latitudeInput.value === '' || longitudeInput.value === '')) {
                    geocodeAddress(locationInput.value);
                    // Chờ một khoảng thời gian cho geocoding hoàn tất
                    await new Promise(resolve => setTimeout(resolve, 1500));
                }
                
                // Trường hợp 2: Ô địa chỉ để trống - lấy vị trí hiện tại
                if (locationInput.value.trim() === '') {
                    try {
                        await getCurrentLocation();
                    } catch (error) {
                        console.error("Không thể lấy vị trí hiện tại:", error);
                        // Nếu không lấy được vị trí hiện tại, thông báo cho người dùng
                        alert('Không thể xác định vị trí hiện tại. Vui lòng nhập địa chỉ của bạn.');
                        return; // Không submit form
                    }
                }
                
                // Kiểm tra cuối cùng trước khi submit
                if (latitudeInput.value === '' || longitudeInput.value === '') {
                    alert('Không thể xác định vị trí. Vui lòng nhập địa chỉ chính xác hoặc kiểm tra lại quyền truy cập vị trí.');
                    return; // Không submit form
                }
                
                // Tất cả đều ổn, submit form
                searchForm.submit();
            });
        });
    </script>
    
    <!-- Phần Blog Mới Nhất -->
    <section class="blog-section latest-blog spad">
        <div class="container">
            <div class="section-title text-center">
                <span>Blog & Tin tức</span>
                <h2>Cập nhật mới nhất thông tin thuê trọ</h2>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-blog-item">
                        <div class="sb-pic">
                            <img src="img/blog/latest-1.jpg" alt="Mẹo tìm phòng trọ">
                        </div>
                        <div class="sb-text">
                            <ul>
                                <li><i class="fa fa-user"></i> Admin</li>
                                <li><i class="fa fa-clock-o"></i> 10 Tháng 3, 2025</li>
                            </ul>
                            <h4><a href="#">5 mẹo quan trọng để tìm phòng trọ nhanh chóng và hiệu quả</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-blog-item">
                        <div class="sb-pic">
                            <img src="img/blog/latest-2.jpg" alt="Hợp đồng thuê trọ">
                        </div>
                        <div class="sb-text">
                            <ul>
                                <li><i class="fa fa-user"></i> Admin</li>
                                <li><i class="fa fa-clock-o"></i> 5 Tháng 3, 2025</li>
                            </ul>
                            <h4><a href="#">Những điều cần lưu ý khi ký hợp đồng thuê trọ</a></h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-blog-item">
                        <div class="sb-pic">
                            <img src="img/blog/latest-3.jpg" alt="Tiết kiệm chi phí thuê trọ">
                        </div>
                        <div class="sb-text">
                            <ul>
                                <li><i class="fa fa-user"></i> Admin</li>
                                <li><i class="fa fa-clock-o"></i> 1 Tháng 3, 2025</li>
                            </ul>
                            <h4><a href="#">Cách tiết kiệm chi phí thuê trọ mà bạn nên biết</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Kết Thúc Phần Blog Mới Nhất -->
    
@endsection

