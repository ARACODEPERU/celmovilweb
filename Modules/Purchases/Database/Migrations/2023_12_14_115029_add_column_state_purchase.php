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
        Schema::table('purc_documents', function (Blueprint $table) {
            $table->string('status', 2)->default('R')->comment('R=registrado,A=anulado,E=EnviadoSUnat,AP=AprovadoSunat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purc_documents', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
