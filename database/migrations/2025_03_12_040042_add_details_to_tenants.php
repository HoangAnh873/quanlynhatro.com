<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('full_name'); // Họ tên
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Giới tính
            $table->date('birth_date')->nullable(); // Ngày sinh
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'gender', 'birth_date']);
        });
    }
};
