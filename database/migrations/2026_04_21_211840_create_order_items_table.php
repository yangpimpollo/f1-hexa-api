<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->string('order_id');
            $table->char('product_id', 5);
            $table->integer('quantity');
            $table->decimal('list_price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);

            // Clave primaria compuesta
            $table->primary(['order_id', 'product_id']);

            // Relaciones
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
