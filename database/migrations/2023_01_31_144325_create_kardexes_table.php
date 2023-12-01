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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_issue');
            $table->enum('motion', ['sale', 'purchase']);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('local_id')->nullable();
            $table->decimal('quantity', 12, 2);
            $table->unsignedBigInteger('document_id')->nullable();
            $table->string('document_entity', 300)->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('local_id')->references('id')->on('local_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardexes');
    }
};
