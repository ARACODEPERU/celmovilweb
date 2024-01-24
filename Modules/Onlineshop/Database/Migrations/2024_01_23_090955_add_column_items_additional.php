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
        Schema::table('onli_items', function (Blueprint $table) {
            $table->text('additional3')->nullable();
            $table->text('additional4')->nullable();
            $table->text('additional5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onli_items', function (Blueprint $table) {
            $table->dropColumn('additional5');
            $table->dropColumn('additional4');
            $table->dropColumn('additional3');
        });
    }
};
