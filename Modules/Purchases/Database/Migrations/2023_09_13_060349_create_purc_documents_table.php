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
        Schema::create('purc_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('local_id')->nullable();
            $table->string('serie')->nullable();
            $table->string('number')->nullable();
            $table->unsignedBigInteger('document_type_id');
            $table->date('date_of_issue')->nullable();
            $table->date('date_of_due')->nullable();
            $table->string('currency_type_id')->nullable();
            $table->string('descripction', 300)->nullable();
            $table->decimal('total_prepayment', 12, 2)->nullable();
            $table->decimal('total_charge', 12, 2)->nullable();
            $table->decimal('total_discount', 12, 2)->nullable();
            $table->decimal('total_exportation', 12, 2)->nullable();
            $table->decimal('total_free', 12, 2)->nullable();
            $table->decimal('total_taxed', 12, 2)->nullable();
            $table->decimal('total_unaffected', 12, 2)->nullable();
            $table->decimal('total_exonerated', 12, 2)->nullable();
            $table->decimal('total_igv', 12, 2)->nullable();
            $table->decimal('total_base_isc', 12, 2)->nullable();
            $table->decimal('total_isc', 12, 2)->nullable();
            $table->decimal('total_base_other_taxes', 12, 2)->nullable();
            $table->decimal('total_other_taxes', 12, 2)->nullable();
            $table->decimal('total_taxes', 12, 2)->nullable();
            $table->decimal('total_value', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('total_canceled', 12, 2)->nullable();
            $table->string('legends', 500)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('people');
            $table->foreign('local_id')->references('id')->on('local_sales');
            $table->foreign('document_type_id')->references('id')->on('sale_document_types');
            $table->foreign('currency_type_id')->references('id')->on('sunat_currency_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purc_documents');
    }
};
