@extends('user.layouts.master')

@section('title', 'Hỗ Trợ')

@section('content')
    
    <!-- Breadcrumb - Điều Hướng -->
    <section class="breadcrumb-section contact-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Liên Hệ Chúng Tôi</h2>
                        <div class="breadcrumb-option">
                            <a href="#"><i class="fa fa-home"></i> Trang Chủ</a>
                            <span>Liên Hệ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Kết Thúc -->

    <!-- Phần Liên Hệ -->
    <section class="contact-section">
        <div class="container-fluid">
            <div class="row">
                <!-- Bản Đồ -->
                <div class="col-lg-6">
                    <div class="contact-map">
                        <iframe
                            src="https://www.google.com/maps?q=123+đường+3/2,Ninh+Kiều,Cần+Thơ&output=embed"
                            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                        <div class="map-inside">
                            <i class="fa fa-map-marker"></i>
                            <div class="inside-widget">
                                <h4>TP. Cần Thơ</h4>
                                <ul>
                                    <li>Điện thoại: (+84) 987 654 321</li>
                                    <li>Địa chỉ: 123 đường 3/2, Ninh Kiều, Cần Thơ.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Liên Hệ -->
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-7 offset-lg-1">
                            <div class="contact-text">
                                <div class="section-title">
                                    <span>Liên Hệ</span>
                                    <h2>Gửi Tin Nhắn Cho Chúng Tôi</h2>
                                </div>
                                <form action="#" class="contact-form">
                                    <input type="text" placeholder="Họ và Tên">
                                    <input type="email" placeholder="Email">
                                    <input type="text" placeholder="Số Điện Thoại">
                                    <textarea placeholder="Nội dung tin nhắn"></textarea>
                                    <button type="submit" class="site-btn">Gửi Tin Nhắn</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Phần Liên Hệ Kết Thúc -->

@endsection