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
        Schema::create('aca_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('aca_students')->onDelete('cascade');
            $table->foreign('registration_id', 'reg_cer_fk')->references('id')->on('aca_cap_registrations')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('aca_courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aca_certificates');
    }
};
