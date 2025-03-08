@extends('user.layouts.master')

@section('title', 'Trang Chủ')

@section('content')

    <!-- Phần Banner Bắt Đầu -->
    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-item set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="hero-text">
                                <p class="room-location"><i class="icon_pin"></i> 123 Đường 3/2, Ninh Kiều, Cần Thơ</p>
                                <h2>Phòng trọ tiện nghi trung tâm Ninh Kiều</h2>
                                <div class="room-price">
                                    <span>Giá thuê từ:</span>
                                    <p>1.000.000 VNĐ/tháng</p>
                                </div>
                                <ul class="room-features">
                                    <li>
                                        <i class="fa fa-arrows"></i>
                                        <p>20m²</p>
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
                                        <p>Wi-Fi miễn phí</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-hero-item set-bg" data-setbg="img/hero/hero-2.jpg">
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
            <div class="single-hero-item set-bg" data-setbg="img/hero/hero-3.jpg">
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
            </div>
        </div>
        <div class="thumbnail-pic">
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
        </div>
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
                    <form action="#" class="filter-form">
                        <div class="first-row row g-3">
                            <div class="col-md-6">
                                <select id="numPeople" class="form-control">
                                    <option value="">Chọn số người</option>
                                    <option value="1">1 người</option>
                                    <option value="2">2 người</option>
                                    <option value="3">3 người</option>
                                    <option value="4">4 người trở lên</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="priceRange" class="form-control">
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
                                <input type="date" id="checkInDate" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="checkOutDate" class="form-label">Ngày trả phòng</label>
                                <input type="date" id="checkOutDate" class="form-control">
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="button" class="search-btn btn btn-primary px-4 py-2">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Phần Tìm Kiếm Phòng Trọ Kết Thúc -->

    {{-- <!-- Phần Nhà Trọ Nổi Bật Bắt Đầu -->
    <section class="feature-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Danh Sách Từ Chủ Trọ</span>
                        <h2>Nhà Trọ Nổi Bật</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="feature-carousel owl-carousel">
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <div class="fi-pic set-bg" data-setbg="img/feature/feature-1.jpg">
                                <div class="pic-tag">
                                    <div class="f-text">Nổi bật</div>
                                    <div class="s-text">Cho Thuê</div>
                                </div>
                                <div class="feature-author">
                                    <div class="fa-pic">
                                        <img src="img/feature/f-author-1.jpg" alt="">
                                    </div>
                                    <div class="fa-text">
                                        <span>Rena Simmons</span>
                                    </div>
                                </div>
                            </div>
                            <div class="fi-text">
                                <div class="inside-text">
                                    <h4>Biệt Thự French Riviera</h4>
                                    <ul>
                                        <li><i class="fa fa-map-marker"></i> 180 York Road, London, UK</li>
                                        <li><i class="fa fa-tag"></i> Biệt thự</li>
                                    </ul>
                                    <h5 class="price">$5900<span>/tháng</span></h5>
                                </div>
                                <ul class="room-features">
                                    <li><i class="fa fa-arrows"></i><p>780 sqft</p></li>
                                    <li><i class="fa fa-bed"></i><p>4</p></li>
                                    <li><i class="fa fa-bath"></i><p>3</p></li>
                                    <li><i class="fa fa-car"></i><p>2</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Thêm các nhà trọ nổi bật khác tại đây -->
                    
                </div>
            </div>
        </div>
    </section>
    <!-- Phần Nhà Trọ Nổi Bật Kết Thúc --> --}}


    {{-- <!-- Phần Video Bắt Đầu -->
    <div class="video-section set-bg" data-setbg="img/video-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <a href="https://www.youtube.com/watch?v=EzKkl64rRbM" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        <h4>Tìm Kiếm Hoàn Hảo</h4>
                        <h2>Nhà Môi Giới Bất Động Sản Gần Bạn</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Phần Video Kết Thúc --> --}}

    {{-- <!-- Phần Nhà Trọ Hàng Đầu Bắt Đầu -->
    <div class="top-properties-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="properties-title">
                        <div class="section-title">
                            <span>Nhà Trọ Tốt Nhất Dành Cho Bạn</span>
                            <h2>Nhà Trọ Hàng Đầu</h2>
                        </div>
                        <a href="#" class="top-property-all">Xem Tất Cả</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="top-properties-carousel owl-carousel">
                <div class="single-top-properties">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="stp-pic">
                                <img src="img/properties/properties-1.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="stp-text">
                                <div class="s-text">Cần Bán</div>
                                <h2>Biệt Thự 9721 Glen Creek</h2>
                                <div class="room-price">
                                    <span>Giá Bắt Đầu Từ:</span>
                                    <h4>$3.000.000</h4>
                                </div>
                                <div class="properties-location"><i class="icon_pin"></i> 9721 Glen Creek Ave. Ballston Spa, NY</div>
                                <p>Một căn biệt thự rộng rãi với không gian sang trọng và đầy đủ tiện nghi.</p>
                                <ul class="room-features">
                                    <li><i class="fa fa-arrows"></i><p>5201 sqft</p></li>
                                    <li><i class="fa fa-bed"></i><p>8 Phòng Ngủ</p></li>
                                    <li><i class="fa fa-bath"></i><p>7 Phòng Tắm</p></li>
                                    <li><i class="fa fa-car"></i><p>1 Gara</p></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Phần Nhà Trọ Hàng Đầu Kết Thúc --> --}}

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

    {{-- <!-- Phần Đối Tác Bắt Đầu -->
    <div class="partner-section">
        <div class="container">
            <div class="partner-carousel owl-carousel">
                <a href="#" class="partner-logo">
                    <div class="partner-logo-tablecell">
                        <img src="img/partner/partner-1.png" alt="Đối tác 1">
                    </div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-logo-tablecell">
                        <img src="img/partner/partner-2.png" alt="Đối tác 2">
                    </div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-logo-tablecell">
                        <img src="img/partner/partner-3.png" alt="Đối tác 3">
                    </div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-logo-tablecell">
                        <img src="img/partner/partner-4.png" alt="Đối tác 4">
                    </div>
                </a>
                <a href="#" class="partner-logo">
                    <div class="partner-logo-tablecell">
                        <img src="img/partner/partner-5.png" alt="Đối tác 5">
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Phần Đối Tác Kết Thúc --> --}}
    
@endsection
