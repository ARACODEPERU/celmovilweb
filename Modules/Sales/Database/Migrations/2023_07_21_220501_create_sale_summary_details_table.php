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
        Schema::create('sale_summary_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->unsignedBigInteger('summary_id')->nullable();
            $table->string('model_name')->nullable();
            $table->string('invoice_type_doc', 2)->nullable();
            $table->string('invoice_serie', 4)->nullable();
            $table->string('invoice_document_name', 20)->nullable();
            $table->integer('invoice_correlative')->nullable();
            $table->boolean('status')->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('sale_documents');
            $table->foreign('summary_id')->references('id')->on('sale_summaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_summary_details');
    }
};
