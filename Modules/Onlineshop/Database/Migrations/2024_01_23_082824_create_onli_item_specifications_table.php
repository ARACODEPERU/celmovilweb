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
        Schema::create('onli_item_specifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('onli_item_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('additonial')->nullable();
            $table->text('additonial1')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onli_item_specifications');
    }
};
