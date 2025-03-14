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
    <div class="search-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="search-form-text text-center mb-3">
                        <div class="search-text">
                            <i class="fa fa-search"></i>
                            Tìm kiếm phòng trọ tại đây
                        </div>
                    </div>
                    <form action="{{ route('user.rooms.search') }}" method="GET" class="filter-form">
                        @csrf
                        <div class="first-row row g-3">
                            <div class="col-md-6">
                                <select name="num_people" class="form-control">
                                    <option value="">Chọn số người</option>
                                    <option value="1">1 người</option>
                                    <option value="2">2 người</option>
                                    <option value="3">3 người</option>
                                    <option value="4">4 người trở lên</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="price" class="form-control">
                                    <option value="">Chọn mức giá</option>
                                    <option value="1000000">Dưới 1 triệu</option>
                                    <option value="1500000">Dưới 1.5 triệu</option>
                                    <option value="2000000">Dưới 2 triệu</option>
                                    <option value="2000001">Trên 2 triệu</option>
                                </select>
                            </div>
                        </div>
                        <div class="second-row row g-3 mt-3">
                            <div class="col-md-6">
                                <label for="checkInDate" class="form-label">Ngày nhận phòng</label>
                                <input type="date" name="check_in_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="checkOutDate" class="form-label">Ngày trả phòng</label>
                                <input type="date" name="check_out_date" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="search-btn btn btn-primary px-4 py-2">Tìm kiếm</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Phần Tìm Kiếm Phòng Trọ Kết Thúc -->


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
