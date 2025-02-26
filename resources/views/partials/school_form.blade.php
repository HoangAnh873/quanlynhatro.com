<div class="form-group">
    <label>Tên Trường</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $school->name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Số Nhà</label>
    <input type="text" name="house_number" class="form-control" value="{{ old('house_number', $school->house_number ?? '') }}">
</div>

<div class="form-group">
    <label>Tên Đường</label>
    <input type="text" name="street" class="form-control" value="{{ old('street', $school->street ?? '') }}">
</div>

<div class="form-group">
    <label>Vĩ Độ</label>
    <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $school->latitude ?? '') }}">
</div>

<div class="form-group">
    <label>Kinh Độ</label>
    <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $school->longitude ?? '') }}">
</div>

<div class="form-group">
    <label>Icon</label>
    <input type="text" name="icon" class="form-control" value="{{ old('icon', $school->icon ?? '') }}">
</div>
