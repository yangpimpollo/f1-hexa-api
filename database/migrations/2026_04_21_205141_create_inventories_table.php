<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->string('store_id');
            $table->char('product_id', 5);
            $table->integer('quantity')->default(0);

            // Clave primaria compuesta para PostgreSQL
            $table->primary(['store_id', 'product_id']);

            // Relaciones
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
