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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('presentations')->default(true)->comment('1 el producto tiene tallas,0 no tiene tallas');
            $table->boolean('is_product')->default(true)->comment('1 es producto, 0 es un servicio');
            $table->char('type_sale_affectation_id', 2)->default('10');
            $table->char('type_purchase_affectation_id', 2)->default('10');
            $table->string('type_unit_measure_id')->default(null);
            $table->boolean('status')->default(true);
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type_unit_measure_id');
            $table->dropColumn('type_sale_affectation_id');
            $table->dropColumn('is_product');
            $table->dropColumn('type_sale_affectation_id');
            $table->dropColumn('presentations');
            $table->dropColumn('status');
            $table->dropColumn('deleted_at');
        });
    }
};
