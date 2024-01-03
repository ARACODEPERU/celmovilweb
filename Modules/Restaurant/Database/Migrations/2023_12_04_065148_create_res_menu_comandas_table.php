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
        Schema::create('res_menu_comandas', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('comanda_id');
            $table->primary(['menu_id', 'comanda_id']);
            $table->foreign('menu_id')->references('id')->on('res_menus')->onDelete('cascade');
            $table->foreign('comanda_id')->references('id')->on('res_comandas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_menu_comandas');
    }
};
