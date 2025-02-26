<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('role', ['admin', 'host', 'tenant']);
            $table->timestamps();
        });

        Schema::create('hosts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('hosts')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('location');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->constrained('apartments')->onDelete('cascade');
            $table->string('room_number');
            $table->integer('capacity');
            $table->decimal('price', 10, 2);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('deposit', 10, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->date('payment_date');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('apartments');
        Schema::dropIfExists('hosts');
        Schema::dropIfExists('users');
    }
};
