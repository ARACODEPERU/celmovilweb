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
        Schema::table('aca_courses', function (Blueprint $table) {
            $table->unsignedBigInteger('modality_id')->nullable();
            $table->foreign('modality_id', 'aca_course_modality_id_fk')->references('id')->on('aca_modalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aca_courses', function (Blueprint $table) {
            $table->dropForeign('aca_course_modality_id_fk');
            $table->dropColumn('modality_id');
        });
    }
};
