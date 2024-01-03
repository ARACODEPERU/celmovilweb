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
        Schema::create('even_event_exhibitors', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('exhibitor_id');
            $table->primary(['event_id', 'exhibitor_id']);
            $table->foreign('event_id')->references('id')->on('even_events')->onDelete('cascade');
            $table->foreign('exhibitor_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('even_event_exhibitors');
    }
};
