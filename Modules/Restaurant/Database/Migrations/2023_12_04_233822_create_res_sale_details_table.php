<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('res_sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('comanda_id');
            $table->integer('quantity');
            $table->decimal('price', 12, 0);
            $table->decimal('discount', 12, 0)->nullable();
            $table->timestamps();
            $table->foreign('sale_id')->references('id')->on('res_sales')->onDelete('cascade');
            $table->foreign('comanda_id')->references('id')->on('res_comandas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_sale_details');
    }
};
