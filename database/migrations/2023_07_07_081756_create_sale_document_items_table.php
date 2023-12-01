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
        Schema::create('sale_document_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('product_id');
            $table->string('cod_product');
            $table->string('decription_product');
            $table->string('unit_type')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->decimal('mto_base_igv', 12, 2)->nullable();
            $table->decimal('percentage_igv', 12, 2)->nullable();
            $table->decimal('igv')->nullable();
            $table->decimal('total_tax', 12, 2)->nullable()->comment('total se impuestos');
            $table->string('type_afe_igv')->nullable();
            $table->decimal('icbper', 12, 2)->nullable()->default(0)->comment('impuesto a la bolsa plastica');
            $table->decimal('factor_icbper', 12, 2)->nullable()->default(0)->comment('(cantidad)*(factor ICBPER)');
            $table->decimal('mto_value_sale', 12, 2)->nullable()->comment('valor unitario * cantidad');
            $table->decimal('mto_value_unit', 12, 2)->nullable()->comment('es el precio menos el igv');
            $table->decimal('mto_price_unit', 12, 2)->nullable()->comment('precio calculado a sunat');
            $table->decimal('price_sale', 12, 2)->nullable()->comment('precio venta del producto');
            $table->decimal('mto_total', 12, 2)->nullable();
            $table->decimal('mto_discount', 12, 2)->nullable()->default(0);
            $table->json('json_discounts')->nullable()->comment('Catalog. 53 (00: Descuento que afecta la Base Imponible)-cantidad * valor unitario-% descuento');
            $table->timestamps();
            $table->foreign('document_id')->references('id')->on('sale_documents')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_document_items');
    }
};
