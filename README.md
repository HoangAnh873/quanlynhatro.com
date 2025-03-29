Hệ Thống Quản Lý Nhà Trọ
1. Giới Thiệu
Đây là dự án cá nhân phát triển độc lập nhằm hỗ trợ chủ nhà trọ quản lý phòng, hợp đồng thuê và thanh toán một cách hiệu quả. Hệ thống cung cấp giao diện quản lý thân thiện và tích hợp bản đồ OpenStreetMap, giúp người dùng dễ dàng tìm kiếm khu trọ theo tên, chủ trọ, địa chỉ và các trường học lân cận (dữ liệu trường học được lấy từ cơ sở dữ liệu).

2. Công Nghệ Sử Dụng
Backend: Laravel (PHP)

Frontend: Blade Template, HTML, CSS, JavaScript, Bootstrap

Bản đồ: OpenStreetMap

Cơ sở dữ liệu: MySQL

3. Chức Năng Chính
Dành cho Quản Trị Viên (Admin)
Quản lý toàn bộ hệ thống: tài khoản, khu trọ, hợp đồng, thanh toán, báo cáo…

Dành cho Chủ Nhà Trọ (Host)
Quản lý phòng: Thêm, sửa, xóa thông tin phòng trọ.

Quản lý hợp đồng thuê và theo dõi thanh toán.

Xem báo cáo và thống kê tình trạng hoạt động của khu trọ.

Dành cho Người Dùng Bình Thường
Tìm kiếm khu trọ theo tên khu trọ, tên chủ trọ, địa chỉ và các trường học lân cận.

Xem thông tin chi tiết khu trọ và định vị trên bản đồ.

Đặt phòng trực tuyến và nhận email xác nhận đơn hàng.

4. Giao Diện Người Dùng
Hệ thống cung cấp 3 giao diện riêng biệt:

Admin: Quản lý hệ thống tổng thể.

Chủ Nhà Trọ: Giao diện dành cho chủ nhà trọ để quản lý phòng và hợp đồng.

Người Dùng: Giao diện thân thiện hỗ trợ tìm kiếm và đặt phòng.

5. Hướng Dẫn Cài Đặt & Chạy Dự Án
5.1. Clone Repository về máy
bash
Copy
Edit
git clone https://github.com/HoangAnh873/quanlynhatro.git
cd quanlynhatro
5.2. Cài Đặt Dependencies
bash
Copy
Edit
composer install
npm install
5.3. Cấu Hình Môi Trường
Copy file .env.example thành .env:

bash
Copy
Edit
cp .env.example .env
Chỉnh sửa thông tin kết nối database trong file .env.

Tạo APP_KEY bằng lệnh:

bash
Copy
Edit
php artisan key:generate
5.4. Tạo Cơ Sở Dữ Liệu
bash
Copy
Edit
php artisan migrate
5.5. Chạy Server
bash
Copy
Edit
php artisan serve
6. Tài Khoản Mặc Định (Seeder)
Chạy lệnh sau để tạo tài khoản mặc định cho Admin và Chủ Nhà Trọ:

bash
Copy
Edit
php artisan db:seed --class=UserSeeder
Sau khi seed, sẽ có:

Tài khoản Chủ Nhà Trọ (Host):

Email: host@example.com

Mật khẩu: 123456

Tài khoản Admin (Quản Trị Viên):

Email: admin@example.com

Mật khẩu: 123456

7. Truy Cập Hệ Thống
Trang chủ: Truy cập http://127.0.0.1:8000/

Trang đăng nhập Admin: Có thể đăng nhập từ trang đăng nhập của chủ nhà trọ.

8. Liên Hệ
Nếu có bất kỳ câu hỏi hoặc cần hỗ trợ, vui lòng liên hệ qua email: hoanganhh080703@gmail.com

✨ Cảm ơn bạn đã sử dụng hệ thống! ✨
