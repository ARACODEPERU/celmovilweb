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
            $table->unsignedBigInteger('teacher_id')->nullable()->comment('se guarda el id  del teacher principal');
            $table->foreign('teacher_id', 'aca_courses_teacher_id_fk')->references('id')->on('aca_teachers')->onDelete('cascade');
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
            $table->dropForeign('aca_courses_teacher_id_fk');
            $table->dropColumn('teacher_id');
        });
    }
};
