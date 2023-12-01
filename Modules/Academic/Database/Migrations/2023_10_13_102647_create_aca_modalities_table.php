<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aca_modalities', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::table('aca_cap_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('modality_id')->nullable();
            $table->foreign('modality_id', 'registration_modality_id_fk')->references('id')->on('aca_modalities')->onDelete('cascade');
        });

        DB::table('aca_modalities')->insert([
            ['description' => 'En Vivo', 'status' => true],
            ['description' => 'Presencial', 'status' => true],
            ['description' => 'E-learning', 'status' => true]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aca_cap_registrations', function (Blueprint $table) {
            $table->dropForeign('registration_modality_id_fk');
            $table->dropColumn('modality_id');
        });
        Schema::dropIfExists('aca_modalities');
    }
};
