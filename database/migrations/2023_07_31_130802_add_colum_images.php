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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('logo_negative')->nullable();
            $table->string('logo_dark')->nullable();
            $table->string('isotipo')->nullable();
            $table->string('isotipo_negative')->nullable();
            $table->string('isotipo_dark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('logo_negative');
            $table->dropColumn('logo_dark');
            $table->dropColumn('isotipo');
            $table->dropColumn('isotipo_negative');
            $table->dropColumn('isotipo_dark');
        });
    }
};
