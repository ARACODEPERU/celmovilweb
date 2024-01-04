<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('usine')->nullable();
            $table->string('interne');
            $table->string('description', 300)->nullable();
            $table->string('image')->nullable();
            $table->decimal('purchase_prices', 12, 2);
            $table->json('sale_prices')->comment('guarda un json cuando el producto precios');
            $table->json('sizes')->nullable()->comment('guarda un json cuando el producto maneja tallas');
            $table->integer('stock_min')->default(1);
            $table->integer('stock')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
