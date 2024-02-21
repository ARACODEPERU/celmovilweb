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
            $table->text('additional6')->nullable();
            $table->text('additional7')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onli_items', function (Blueprint $table) {
            $table->dropColumn('additional6');
            $table->dropColumn('additional7');
        });
    }
};
