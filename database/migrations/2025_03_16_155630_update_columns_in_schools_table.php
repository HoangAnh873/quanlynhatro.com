<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Đổi tên cột
            $table->renameColumn('house_number', 'location');
            $table->renameColumn('latitude', 'GPS_Latitude');
            $table->renameColumn('longitude', 'GPS_Longitude');

            // Xóa cột street
            $table->dropColumn('street');
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            // Đổi tên lại nếu rollback
            $table->renameColumn('location', 'house_number');
            $table->renameColumn('GPS_Latitude', 'latitude');
            $table->renameColumn('GPS_Longitude', 'longitude');

            // Thêm lại cột street (kiểu dữ liệu string là ví dụ, mày sửa lại nếu cần)
            $table->string('street')->nullable();
        });
    }
};
