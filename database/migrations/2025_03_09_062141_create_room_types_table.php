<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->integer('max_occupants')->default(1);
            $table->float('area');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_types');
    }
};
