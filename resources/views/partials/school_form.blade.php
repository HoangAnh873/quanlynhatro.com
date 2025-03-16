<div class="form-group">
    <label>Tên Trường</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', isset($school) ? $school->name : '') }}" required>
</div>

<div class="form-group">
    <label>Icon Đại Diện</label>
    <input type="file" name="icon" class="form-control">
    @if (isset($school) && $school->icon)
        <p>Icon hiện tại:</p>
        <img src="{{ asset('img/icons/' . $school->icon) }}" alt="icon" width="50">
    @endif
</div>

<div class="form-group">
    <label>Địa Chỉ</label>
    <input type="text" id="location" name="location" class="form-control" value="{{ old('location', isset($school) ? $school->location : '') }}" onblur="getCoordinates()">
</div>

<div class="form-group">
    <label>Vĩ Độ</label>
    <input type="text" id="GPS_Latitude" name="GPS_Latitude" class="form-control" value="{{ old('GPS_Latitude', isset($school) ? $school->GPS_Latitude : '') }}" readonly>
</div>

<div class="form-group">
    <label>Kinh Độ</label>
    <input type="text" id="GPS_Longitude" name="GPS_Longitude" class="form-control" value="{{ old('GPS_Longitude', isset($school) ? $school->GPS_Longitude : '') }}" readonly>
</div>


<div id="address_details"></div>

{{-- Nhúng Google Maps API --}}
<script>
    function getCoordinates() {
        let address = document.getElementById('location').value.trim();
        let latInput = document.getElementById('GPS_Latitude');
        let lonInput = document.getElementById('GPS_Longitude');
        let detailsDiv = document.getElementById('address_details');
        
        // Xóa dữ liệu cũ
        latInput.value = "";
        lonInput.value = "";
        if (detailsDiv) detailsDiv.innerHTML = "";
        
        if (!address) {
            alert("Vui lòng nhập địa chỉ!");
            return;
        }
        
        // Lưu lại địa chỉ gốc người dùng nhập
        const originalAddress = address;
        
        // Đảm bảo địa chỉ có chứa "Cần Thơ"
        if (!address.toLowerCase().includes("cần thơ")) {
            address += ", Cần Thơ";
        }
        
        // Thêm tham số chi tiết và giảm mức độ mờ trong tìm kiếm
        let url = `https://nominatim.openstreetmap.org/search?format=json&countrycodes=VN&addressdetails=1&limit=5&dedupe=1&q=${encodeURIComponent(address)}`;
        
        // Hiển thị thông báo đang tìm kiếm
        if (!detailsDiv) {
            detailsDiv = document.createElement('div');
            detailsDiv.id = 'address_details';
            document.getElementById('location').parentNode.appendChild(detailsDiv);
        }
        detailsDiv.innerHTML = '<p>Đang tìm kiếm địa chỉ...</p>';
        
        fetch(url, { 
            headers: { 
                'User-Agent': 'YourAppName/1.0', 
                'Accept-Language': 'vi' 
            } 
        })
        .then(response => response.json())
        .then(data => {
            console.log("📌 API Response:", data);
            
            if (data.length > 0) {
                // Tìm kết quả phù hợp nhất
                let bestMatch = findBestMatch(data, originalAddress);
                
                // Gán tọa độ tìm được
                latInput.value = bestMatch.lat;
                lonInput.value = bestMatch.lon;
                
                // Hiển thị thông tin địa chỉ chi tiết
                const addressDetails = bestMatch.address;
                let detailsHTML = '<h4>Thông tin địa chỉ chi tiết:</h4>';
                
                // Hiển thị so sánh địa chỉ
                detailsHTML += `
                    <div style="margin-bottom: 10px; padding: 8px; background-color: #f8f9fa; border-radius: 4px;">
                        <strong>Địa chỉ nhập vào:</strong> ${originalAddress}<br>
                        <strong>Địa chỉ tìm thấy:</strong> ${bestMatch.display_name}
                    </div>
                `;
                
                // Hiển thị bảng thông tin chi tiết
                detailsHTML += '<table style="width:100%; border-collapse:collapse;">';
                let hasDetails = false;
                
                const fieldLabels = {
                    house_number: 'Số nhà',
                    road: 'Đường',
                    neighbourhood: 'Khu vực/Xóm',
                    suburb: 'Phường/Xã',
                    city_district: 'Quận/Huyện',
                    city: 'Thành phố',
                    state: 'Tỉnh',
                    postcode: 'Mã bưu chính',
                    country: 'Quốc gia'
                };
                
                for (const [key, label] of Object.entries(fieldLabels)) {
                    if (addressDetails[key]) {
                        detailsHTML += `<tr>
                            <td style="border:1px solid #ddd; padding:8px; font-weight:bold;">${label}</td>
                            <td style="border:1px solid #ddd; padding:8px;">${addressDetails[key]}</td>
                        </tr>`;
                        hasDetails = true;
                    }
                }
                detailsHTML += '</table>';
                
                // Thêm link xem trên bản đồ
                detailsHTML += `
                    <div style="margin-top: 15px;">
                        <a href="https://www.openstreetmap.org/?mlat=${bestMatch.lat}&mlon=${bestMatch.lon}&zoom=16" 
                        target="_blank" style="display: inline-block; padding: 5px 10px; background-color: #4285f4; 
                        color: white; text-decoration: none; border-radius: 4px;">
                        🔍 Xem trên bản đồ
                        </a>
                    </div>
                `;
                
                detailsDiv.innerHTML = hasDetails ? detailsHTML : '<p>Không tìm thấy thông tin chi tiết.</p>';
            } else {
                detailsDiv.innerHTML = '<p style="color: red;">❌ Không tìm thấy tọa độ! Hãy nhập địa chỉ rõ hơn.</p>';
            }
        })
        .catch(error => {
            console.error("❌ Lỗi lấy tọa độ:", error);
            detailsDiv.innerHTML = `<p style="color: red;">⚠️ Lỗi khi lấy dữ liệu: ${error.message}</p>`;
        });
    }

    // Hàm tìm kết quả phù hợp nhất với địa chỉ người dùng nhập
    function findBestMatch(locations, originalAddress) {
        if (locations.length === 1) return locations[0];
        
        // Chuyển địa chỉ gốc thành chữ thường và loại bỏ dấu để so sánh
        const normalizedOriginal = normalizeVietnamese(originalAddress.toLowerCase());
        
        // Tính điểm tương đồng cho mỗi kết quả
        const scoredLocations = locations.map(location => {
            const displayName = location.display_name.toLowerCase();
            const normalizedDisplay = normalizeVietnamese(displayName);
            
            // Tính điểm dựa trên mức độ tương đồng và đầy đủ thông tin
            let score = 0;
            
            // Kiểm tra từng phần của địa chỉ gốc có xuất hiện trong kết quả không
            const originalParts = normalizedOriginal.split(/[,\s]+/).filter(part => part.length > 2);
            originalParts.forEach(part => {
                if (normalizedDisplay.includes(part)) {
                    score += 10;
                }
            });
            
            // Ưu tiên các địa chỉ có đủ thông tin chi tiết
            const addressDetail = location.address;
            ['road', 'suburb', 'city_district'].forEach(field => {
                if (addressDetail[field]) score += 5;
            });
            
            // Ưu tiên các kết quả có importance cao hơn (trường của Nominatim)
            if (location.importance) {
                score += location.importance * 20;
            }
            
            return { location, score };
        });
        
        // Sắp xếp theo điểm và trả về kết quả tốt nhất
        scoredLocations.sort((a, b) => b.score - a.score);
        console.log("📊 Scored Locations:", scoredLocations);
        
        return scoredLocations[0].location;
    }

    // Hàm chuẩn hóa tiếng Việt (bỏ dấu) để so sánh tốt hơn
    function normalizeVietnamese(str) {
        return str.normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd').replace(/Đ/g, 'D');
    }

    // Hàm xử lý khi người dùng chọn địa điểm thay thế
    function selectAlternativeLocation(index) {
        if (!index || !window.allLocations) return;
        
        const selectedLocation = window.allLocations[index];
        if (!selectedLocation) return;
        
        // Cập nhật tọa độ
        document.getElementById('GPS_Latitude').value = selectedLocation.lat;
        document.getElementById('GPS_Longitude').value = selectedLocation.lon;
        
        // Cập nhật thông tin chi tiết
        const detailsDiv = document.getElementById('address_details');
        if (detailsDiv) {
            // Gọi lại hàm để hiển thị thông tin của địa điểm được chọn
            // Hoặc có thể viết lại logic hiển thị ở đây
            getCoordinates();
        }
    }

</script>