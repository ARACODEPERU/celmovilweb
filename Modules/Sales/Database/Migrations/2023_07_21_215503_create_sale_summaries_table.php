<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('summary_name', 100)->nullable();
            $table->dateTime('generation_date');
            $table->dateTime('summary_date');
            $table->string('correlative')->nullable();
            $table->string('sunat_points')->nullable();
            $table->string('ticket', 100)->nullable();
            $table->string('cdr', 500)->nullable();
            $table->string('xml', 500)->nullable();
            $table->string('pdf', 500)->nullable();
            $table->string('response_code', 10)->nullable();
            $table->text('response_description')->nullable();
            $table->json('notes')->nullable();
            $table->string('status', 40)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('anio', 4)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_summaries');
    }
};
