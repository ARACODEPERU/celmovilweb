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

        Schema::create('aca_contents', function (Blueprint $table) {
            $table->id();
            $table->string('position', 4);
            $table->string('description', 300);
            $table->text('content');
            $table->unsignedBigInteger('theme_id');
            $table->timestamps();
            $table->boolean('is_file')->default(true);
            $table->foreign('theme_id')->references('id')->on('aca_themes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aca_contents');
    }
};
