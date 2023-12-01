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
        Schema::table('onli_items', function (Blueprint $table) {
            $table->text('additional')->nullable();
            $table->text('additional1')->nullable();
            $table->text('additional2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onli_items', function (Blueprint $table) {
            $table->dropColumn('additional2');
            $table->dropColumn('additional1');
            $table->dropColumn('additional');
        });
    }
};
