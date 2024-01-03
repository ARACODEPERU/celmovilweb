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
        Schema::create('sale_physical_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('user_id');
            $table->string('document_type')->nullable();
            $table->string('serie')->nullable();
            $table->string('corelative');
            $table->date('document_date');
            $table->date('document_expiration')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('client_type_doc')->nullable();
            $table->string('client_number')->nullable();
            $table->string('client_rzn_social')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_ubigeo_code')->nullable();
            $table->string('client_ubigeo_description')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->json('products')->nullable();
            $table->json('payments')->nullable();
            $table->decimal('total', 12, 2);
            $table->string('status', 2)->default('R')->comment('R=registrado,A=anulado,E=EnviadoSUnat,AP=AprovadoSunat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_physical_documents');
    }
};
