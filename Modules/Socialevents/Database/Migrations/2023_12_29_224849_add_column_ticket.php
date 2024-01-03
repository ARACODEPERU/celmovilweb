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
        Schema::table('even_event_ticket_clients', function (Blueprint $table) {
            $table->string('response_status')->nullable();
            $table->string('response_id')->nullable();
            $table->string('response_date_approved')->nullable();
            $table->json('response_payer')->nullable();
            $table->string('response_payment_method_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('even_event_ticket_clients', function (Blueprint $table) {
            $table->dropColumn('response_payment_method_id');
            $table->dropColumn('response_payer');
            $table->dropColumn('response_date_approved');
            $table->dropColumn('response_id');
            $table->dropColumn('response_status');
        });
    }
};
