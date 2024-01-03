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
        Schema::create('help_ticket_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_attend_id')->nullable()->comment('usuario que esta atendiendo');
            $table->text('comment_activity')->nullable();
            $table->string('process', 2)->comment('RE=registrado,CA=Cancelado,AT=Atendido,DE=Derivado,TE=Terminado,RC=Rechazado');
            $table->unsignedBigInteger('level_id')->comment('nivel actual donde se atiende');
            $table->timestamps();
            $table->foreign('level_id')->references('id')->on('help_levels');
            $table->foreign('user_attend_id')->references('id')->on('users');
            $table->foreign('ticket_id')->references('id')->on('help_tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_ticket_activities');
    }
};
