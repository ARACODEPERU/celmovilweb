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
        Schema::create('cms_section_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('section_id')->comment('a que seccion pertenesera el item o grupo de items');
            $table->integer('position')->default(0)->comment('de ser nesesario, saber en que  posicion se mostrara');
            $table->string('description')->nullable()->comment('de hacer falta una descripcion del nuevo componente');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('cms_items')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('cms_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_section_items');
    }
};
