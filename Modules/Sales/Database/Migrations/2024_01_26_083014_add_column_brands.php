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
        Schema::table('sale_product_brands', function (Blueprint $table) {
            $table->string('image', 300)->nullable();
            $table->boolean('status')->default(true);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id', 'product_brand_fk')->references('id')->on('sale_product_brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_product_brands', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('image');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('product_brand_fk');
        });
    }
};
