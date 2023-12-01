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
        Schema::create('cms_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('item_id')->nullable()->comment('en caso el item pertenesca a un conjunto de items');
            $table->integer('position')->default(0)->comment('la posicion en que estara el item');
            $table->text('content')->nullable()->comment('contenido del item (texto, un link, ruta de imagen o archivo)');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('cms_items')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('cms_item_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_items');
    }
};
