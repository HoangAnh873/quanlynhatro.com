<div class="form-group">
    <label>Họ và Tên</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Email (Tài Khoản)</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="form-group">
    <label>Mật Khẩu</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
    @if(isset($user))
        <small>Để trống nếu không muốn thay đổi mật khẩu</small>
    @endif
</div>

<div class="form-group">
    <label>Vai Trò</label>
    <select name="role" class="form-control" required>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="host" {{ old('role', $user->role ?? '') == 'host' ? 'selected' : '' }}>Chủ trọ</option>
    </select>
</div>
