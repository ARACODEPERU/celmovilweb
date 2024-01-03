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
        Schema::table('purc_document_items', function (Blueprint $table) {
            $table->string('size')->nullable()->comment('se registra en caso de tener talla');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purc_document_items', function (Blueprint $table) {
            $table->dropColumn('size');
        });
    }
};
