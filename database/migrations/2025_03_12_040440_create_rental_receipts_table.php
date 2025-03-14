<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rental_receipts', function (Blueprint $table) {
            $table->id(); // IDPhieuThue
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade'); // Người thuê
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // Phòng thuê
            $table->date('start_date'); // Ngày bắt đầu thuê
            $table->date('end_date'); // Ngày kết thúc thuê
            $table->date('issued_date')->default(now()); // Ngày lập phiếu
            $table->decimal('deposit', 15, 2); // Tiền cọc
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái phiếu
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rental_receipts');
    }
};
