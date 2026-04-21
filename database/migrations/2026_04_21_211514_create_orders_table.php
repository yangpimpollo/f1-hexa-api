<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary(); 
            $table->string('customer_dni');
            $table->string('store_id');
            $table->unsignedBigInteger('staff_id'); // Usuario que vendió
            
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->timestamp('order_date')->useCurrent();

            // Relaciones
            $table->foreign('customer_dni')->references('dni')->on('customers');
            $table->foreign('store_id')->references('store_id')->on('stores');
            $table->foreign('staff_id')->references('id')->on('my_users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
