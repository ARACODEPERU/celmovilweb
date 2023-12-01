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
        Schema::create('heal_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('patient_code');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('people', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->comment('fecha de nacimiento');
            $table->string('names')->nullable()->comment('nombres');
            $table->string('father_lastname')->nullable()->comment('apellido paterno');
            $table->string('mother_lastname')->nullable()->comment('apallido materno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heal_patients');

        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('birthdate');
        });
    }
};
