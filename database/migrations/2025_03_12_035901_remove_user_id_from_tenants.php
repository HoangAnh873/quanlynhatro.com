<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Xóa ràng buộc khóa ngoại nếu có
            $table->dropColumn('user_id'); // Xóa cột user_id
        });
    }

    public function down()
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
        });
    }
};
