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
        Schema::create('cms_page_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('section_id');
            $table->string('description')->nullable()->comment('en caso ser nesesario una descripcion');
            $table->timestamps();
            $table->foreign('page_id')->references('id')->on('cms_pages')->onDelete('cascade');
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
        Schema::dropIfExists('cms_page_sections');
    }
};
