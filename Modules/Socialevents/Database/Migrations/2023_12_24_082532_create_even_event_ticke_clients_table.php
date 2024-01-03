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
        Schema::create('even_event_ticket_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('usuario que registro');
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('ticket_price_id');
            $table->string('full_name', 500);
            $table->string('identification_number', 12);
            $table->string('phone', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('ubigeo')->nullable();
            $table->string('name_city', 300)->nullable();
            $table->integer('quantity')->default(1)->comment('cantidad de entradas compradas');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('even_event_ticke_clients');
    }
};
