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
        Schema::table('even_events', function (Blueprint $table) {
            $table->integer('tickets_available')->default(0)->comment('entradas que van quedando');
        });
        Schema::table('even_event_ticket_prices', function (Blueprint $table) {
            $table->integer('tickets_available')->default(0)->comment('entradas que van quedando');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('even_events', function (Blueprint $table) {
            $table->dropColumn('tickets_available');
        });
        Schema::table('even_event_ticket_prices', function (Blueprint $table) {
            $table->dropColumn('tickets_available');
        });
    }
};
