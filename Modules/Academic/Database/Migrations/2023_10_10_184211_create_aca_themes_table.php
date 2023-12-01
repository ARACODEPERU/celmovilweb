<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aca_themes', function (Blueprint $table) {
            $table->id();
            $table->string('position', 4);
            $table->string('description', 300);
            $table->unsignedBigInteger('module_id');
            $table->timestamps();
            $table->foreign('module_id')->references('id')->on('aca_modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aca_themes');
    }
};
