<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('my_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('store_id'); 
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('my_user');
    }
};
