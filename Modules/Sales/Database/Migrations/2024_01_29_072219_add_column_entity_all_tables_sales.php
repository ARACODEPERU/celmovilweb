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
        Schema::table('sale_products', function (Blueprint $table) {
            $table->string('entity_name_product')->nullable()->comment('para saber de que modulo es el producto');
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
        Schema::table('sale_document_items', function (Blueprint $table) {
            $table->string('entity_name_product')->nullable()->comment('para saber de que modulo es el producto');
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
        Schema::table('sale_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->dropColumn('entity_name_product');
        });
        Schema::table('sale_document_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->change();
            $table->unsignedBigInteger('sale_id')->change();
            $table->dropColumn('entity_name_product');
        });
        Schema::table('sale_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('sale_id')->change();
        });
    }
};
