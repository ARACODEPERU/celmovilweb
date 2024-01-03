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
        Schema::create('res_sales', function (Blueprint $table) {
            $table->id();
            $table->date('sale_date')->comment('fecha que se vendio');
            $table->time('sale_hour')->comment('hora que se vendio');
            $table->string('correlative');
            $table->unsignedBigInteger('petty_cash_id')->comment('id caja chica');
            $table->unsignedBigInteger('user_id')->comment('usuario que registra');
            $table->unsignedBigInteger('person_id')->comment('id del cliente');
            $table->unsignedBigInteger('local_id')->comment('local donde fue vendivo');
            $table->decimal('total', 12, 2)->nullable()->comment('total del documento');
            $table->decimal('total_discount', 12, 2)->nullable();
            $table->json('payments')->nullable()->comment('metodos de pago');
            $table->timestamps();
            $table->foreign('petty_cash_id')->references('id')->on('petty_cashes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('local_id')->references('id')->on('local_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_sales');
    }
};
