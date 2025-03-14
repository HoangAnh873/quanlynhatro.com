<!-- Header Section Begin -->
<header class="header-section">
    <div class="top-nav">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <nav class="main-menu">
                        <ul>
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Trang chủ</a>
                            </li>
                            <li class="{{ request()->routeIs('user.apartments.list') ? 'active' : '' }}">
                                <a href="{{ route('user.apartments.list') }}">Danh sách khu trọ</a>
                            </li>
                            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                                <a href="{{ route('contact') }}">Hỗ trợ</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-5">
                    <div class="top-right">
                        <div class="language-option">
                            {{-- <img src="{{ asset('img/flag1.png') }}" alt=""> --}}
                            <span>Tiếng Việt</span>
                            <i class="fa fa-angle-down"></i>
                            <div class="flag-dropdown">
                                <ul>
                                    <li><a href="#">Tiếng Việt</a></li>
                                    <li><a  href="#">English</a></li>
                                    <li><a href="#">中文</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ route('login') }}" class="property-sub">Đăng nhập chủ trọ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="nav-logo">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="nav-logo-right">
                        <ul>
                            <li>
                                <i class="icon_phone"></i>
                                <div class="info-text">
                                    <span>Điện thoại:</span>
                                    <p>(+84) 123 456 789</p>
                                </div>
                            </li>
                            <li>
                                <i class="icon_map"></i>
                                <div class="info-text">
                                    <span>Địa chỉ:</span>
                                    <p>123 Đường ABC, <span>Hà Nội</span></p>
                                </div>
                            </li>
                            <li>
                                <i class="icon_mail"></i>
                                <div class="info-text">
                                    <span>Email:</span>
                                    <p>lienhe@phongtro.vn</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</header>
<!-- Header End -->
