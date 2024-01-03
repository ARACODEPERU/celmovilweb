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
        Schema::create('res_comandas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nombre del producto');
            $table->text('description')->nullable()->comment('descripcion del producto');
            $table->string('image')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('presentation_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('res_categories')->onDelete('cascade');
            $table->foreign('presentation_id')->references('id')->on('res_presentations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_comandas');
    }
};
