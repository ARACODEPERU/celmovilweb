<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->unsignedBigInteger('local_sale_id')->nullable();
            $table->foreign('local_sale_id', 'local_sale_id_fk')->references('id')->on('local_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('petty_cashes', function (Blueprint $table) {
            $table->dropForeign('local_sale_id_fk');
            $table->dropColumn('local_sale_id');
        });
    }
};
