<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->decimal('GPS_Latitude', 10, 8)->nullable()->after('location');
            $table->decimal('GPS_Longitude', 11, 8)->nullable()->after('GPS_Latitude');
        });
    }
    
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn(['GPS_Latitude', 'GPS_Longitude']);
        });
    }
};
