<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('number')->nullable();
            $table->string('number_cci')->nullable();
            $table->timestamps();
        });

        DB::table('payment_methods')->insert([
            ['description' => 'Efectivo', 'number' => null],
            ['description' => 'Yape', 'number' => '123456789'],
            ['description' => 'Pim', 'number' => '123456789'],
            ['description' => 'Transferencia BCP', 'number' => '123456789'],
            ['description' => 'Transferencia BBVA', 'number' => '123456789']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
