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
        Schema::create('purc_document_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id');
            $table->date('date_of_due');
            $table->string('affectation_igv_type_id');
            $table->string('price_type_id');
            $table->decimal('quantity', 12, 2);
            $table->decimal('unit_value', 12, 2);
            $table->decimal('total_base_igv', 12, 2);
            $table->decimal('percentage_igv', 12, 2);
            $table->decimal('total_igv', 12, 2);
            $table->decimal('total_base_isc', 12, 2);
            $table->decimal('percentage_isc', 12, 2);
            $table->decimal('total_isc', 12, 2);
            $table->decimal('total_base_other_taxes', 12, 2);
            $table->decimal('percentage_other_taxes', 12, 2);
            $table->decimal('total_other_taxes', 12, 2);
            $table->decimal('total_taxes', 12, 2);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_value', 12, 2);
            $table->decimal('total_charge', 12, 2);
            $table->decimal('total_discount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->json('discounts')->nullable();
            $table->timestamps();
            $table->foreign('purchase_id')->references('id')->on('purc_documents');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('affectation_igv_type_id')->references('id')->on('sunat_affectation_igv_types');
            $table->foreign('price_type_id')->references('id')->on('sunat_price_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purc_document_items');
    }
};
