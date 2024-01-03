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
        Schema::create('even_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title', 500)->nullable()->comment('titulo del evento');
            $table->text('description')->nullable()->comment('descripcion del evento');
            $table->text('iframe_transmission')->nullable()->comment('en caso la transmision sea en vivo');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->text('advertising_video')->nullable()->comment('video de publicidad');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->integer('number_days')->default(1);
            $table->integer('tickets_quantity')->default(100);
            $table->string('status', 2)->default('PE')->comment('PE=pendiente,PR=enproceso,TE=terminado,CA=Cancelado,PO=postergado');
            $table->boolean('broadcast')->default(false)->comment('en caso el evento sera transmitodo en la web');
            $table->boolean('just_transmit')->default(false)->comment('si solo es transmision en vivo esta en true');
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('even_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('even_events');
    }
};
