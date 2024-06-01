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
        Schema::table('onli_sales', function (Blueprint $table) {
            $table->string('mercado_payment_id')->nullable();
            $table->json('mercado_payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('onli_sales', function (Blueprint $table) {
            $table->dropColumn('mercado_payment_id');
            $table->dropColumn('mercado_payment');
        });
    }
};
