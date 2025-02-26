<div class="form-group">
    <label>Họ và Tên</label>
    <input type="text" name="full_name" class="form-control"
        value="{{ old('full_name', $host->user->name ?? '') }}" 
        required
    >
</div>

<div class="form-group">
    <label>Email (Tài Khoản)</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $host->user->email ?? '') }}" required>
</div>

<div class="form-group">
    <label>Mật Khẩu</label>
    <input type="password" name="password" class="form-control" {{ isset($host) ? '' : 'required' }}>
    @if(isset($host))
        <small>Để trống nếu không muốn thay đổi mật khẩu</small>
    @endif
</div>

<div class="form-group">
    <label>Số Điện Thoại</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $host->phone ?? '') }}" required>
</div>

<div class="form-group">
    <label>Địa Chỉ</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $host->address ?? '') }}" required>
</div>
