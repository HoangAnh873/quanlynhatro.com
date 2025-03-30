# 🌟 Hệ Thống Quản Lý Nhà Trọ

## 1. Giới Thiệu
Hệ thống quản lý nhà trọ là một nền tảng giúp chủ nhà trọ quản lý phòng, hợp đồng thuê và thanh toán một cách hiệu quả.

Hệ thống cung cấp:
- **Giao diện thân thiện** giúp người dùng dễ dàng thao tác.
- **Tích hợp bản đồ MapBox** để tìm kiếm khu trọ theo tên, chủ trọ, địa chỉ và các trường học lân cận.
- **Hỗ trợ đặt phòng trực tuyến** 

## 2. Công Nghệ Sử Dụng  
- **Backend:** Laravel (PHP)  
- **Frontend:** Blade Template, HTML, CSS, JavaScript, Bootstrap  
- **Bản đồ:** MapBox 
- **Cơ sở dữ liệu:** MySQL  

## 3. Chức Năng Chính  
### 💼 Dành cho Quản Trị Viên (Admin)  
- Quản lý toàn bộ hệ thống: **tài khoản, khu trọ, hợp đồng, thanh toán, báo cáo...**  

### 🏠 Dành cho Chủ Nhà Trọ (Host)  
- Quản lý phòng trọ: **Thêm, sửa, xóa thông tin phòng.**  
- Quản lý hợp đồng thuê và theo dõi thanh toán.  
- Xem **báo cáo & thống kê** về khu trọ.  

### 👥 Dành cho Người Dùng (Khách Thuê)  
- **Tìm kiếm khu trọ** theo tên, địa chỉ, hoặc trường học lân cận.  
- Xem **thông tin chi tiết & vị trí trên bản đồ**.  
- **Đặt phòng trực tuyến** và nhận email xác nhận.  

## 4. Giao Diện Người Dùng  
Hệ thống có **3 giao diện chính**:
- **Admin:** Quản lý hệ thống tổng thể.  
- **Chủ Nhà Trọ:** Quản lý phòng trọ & hợp đồng.  
- **Người Dùng:** Tìm kiếm & đặt phòng dễ dàng.  

## 5. Hướng Dẫn Cài Đặt & Chạy Dự Án  
### 📂 5.1. Clone Repository  
```sh  
git clone <repo_url>  
cd quanlynhatro.com
```

### 📂 5.2. Cài Đặt Dependencies  
```sh  
composer install  
```

### 📂 5.3. Cấu Hình Môi Trường  
- Copy file `.env.example` thành `.env`:
```sh  
cp .env.example .env  
```
- Chỉnh sửa thông tin kết nối **database** trong file `.env`.
- Tạo `APP_KEY`:
```sh  
php artisan key:generate  
```

### 📂 5.4. Tạo Cơ Sở Dữ Liệu  
```sh  
php artisan migrate  
```

### 📂 5.5. Chạy Server  
```sh  
php artisan serve  
```

## 6. Tài Khoản Mặc Định (Seeder)  
Chạy lệnh sau để tạo tài khoản mặc định:  
```sh  
php artisan db:seed --class=UserSeeder  
```
### 🔑 Tài khoản mặc định:
#### Chủ Nhà Trọ (Host):  
- **Email:** host@example.com  
- **Mật khẩu:** 123456  

#### Quản Trị Viên (Admin):  
- **Email:** admin@example.com  
- **Mật khẩu:** 123456  

## 7. Truy Cập Hệ Thống  
- **🌍 Trang chủ:** Mở trình duyệt và truy cập `http://127.0.0.1:8000/`

## 📧 Liên Hệ  
📩 Nếu có bất kỳ câu hỏi hoặc cần hỗ trợ, vui lòng liên hệ qua email: **hoanganhh080703@gmail.com**  

💡 **✨ Cảm ơn bạn đã sử dụng hệ thống! ✨** 🚀

