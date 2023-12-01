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
        Schema::create('sale_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('sunat_id');
            $table->timestamps();
        });

        DB::table('sale_document_types')->insert([
            ['description' => 'FACTURA', 'sunat_id' => '01'],
            ['description' => 'BOLETA DE VENTA', 'sunat_id' => '03'],
            ['description' => 'NOTA DE CRÉDITO', 'sunat_id' => '07'],
            ['description' => 'NOTA DE DÉBITO', 'sunat_id' => '08'],
            ['description' => 'NOTA DE VENTA', 'sunat_id' => '80'],
            ['description' => 'GUIA DE REMISIÓN REMITENTE', 'sunat_id' => '09']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_document_types');
    }
};
