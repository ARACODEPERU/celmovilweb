<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('help_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('incident_id');
            $table->text('description_dissent');
            $table->unsignedBigInteger('board_id')->nullable()->comment('tablero a donde llega el ticket');
            $table->unsignedBigInteger('company_client_user_id')->nullable()->comment('id de la empres');
            $table->unsignedBigInteger('user_request_id')->nullable()->comment('usuario que registro la solicitud');
            $table->unsignedBigInteger('user_attend_id')->comment('usuario que esta atendiendo');
            $table->string('user_request_names', 300)->nullable()->comment('nombre usuario registro');
            $table->string('user_database')->nullable()->comment('nombre usuario registro');
            $table->unsignedBigInteger('level_id')->comment('nivel a donde llego');
            $table->text('description_solution');
            $table->string('process', 2)->comment('RE=registrado,CA=Cancelado,AT=Atendido,DE=Derivado,TE=Terminado,RC=Rechazado');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('help_categories');
            $table->foreign('incident_id')->references('id')->on('help_incidents');
            $table->foreign('board_id')->references('id')->on('help_board_levels');
            $table->foreign('user_attend_id')->references('id')->on('users');
            $table->foreign('level_id')->references('id')->on('help_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_tickets');
    }
};
