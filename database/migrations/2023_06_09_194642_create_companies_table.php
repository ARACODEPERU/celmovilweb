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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 15);
            $table->string('name', 300);
            $table->string('business_name', 300)->nullable();
            $table->string('tradename', 300)->nullable();
            $table->string('fiscal_address', 300)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('representative', 300)->nullable();
            $table->string('email', 300)->nullable();
            $table->string('logo', 150)->nullable();
            $table->string('logo_document', 150)->nullable();
            $table->string('key_sunat', 150)->nullable();
            $table->string('user_sunat', 150)->nullable();
            $table->string('certificate_sunat', 150)->nullable();
            $table->string('mode', 4)->default('demo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
