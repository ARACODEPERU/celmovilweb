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
        Schema::table('help_boards', function (Blueprint $table) {
            $table->unsignedBigInteger('client_user_id')->nullable();
            $table->foreign('client_user_id', 'help_board_client_user_id_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('help_boards', function (Blueprint $table) {
            $table->dropColumn('client_user_id');
        });
    }
};
