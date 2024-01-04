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
        Schema::create('identity_document_type', function (Blueprint $table) {
            $table->string('id');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('document_type_id')->nullable();
            $table->string('short_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('description')->nullable();
            $table->string('number')->unique();
            $table->string('telephone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_telephone')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->boolean('is_provider')->nullable();
            $table->boolean('is_client')->nullable();
            $table->string('ubigeo')->nullable();
            $table->timestamps();
        });

        DB::table('identity_document_type')->insert([
            ['id' => '0', 'description' => 'Doc.trib.no.dom.sin.ruc'],
            ['id' => '1', 'description' => 'DNI'],
            ['id' => '6', 'description' => 'RUC']
        ]);

        DB::table('people')->insert([
            [
                'document_type_id' => '0',
                'short_name' => 'Clientes Varios',
                'full_name' => 'Clientes Varios',
                'number' => '99999999',
                'is_client' => true,
                'ubigeo' => '021801',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
        Schema::dropIfExists('identity_document_type');
    }
};
