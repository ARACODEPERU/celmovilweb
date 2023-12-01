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
        Schema::create('onli_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->string('entitie');
            $table->string('category_description')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('scor')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('discount', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        Schema::table('onli_sale_details', function (Blueprint $table) {
            $table->unsignedBigInteger('onli_item_id')->nullable();
            $table->foreign('onli_item_id', 'onli_items_item_id_fk')->references('id')->on('onli_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onli_sale_details', function (Blueprint $table) {
            $table->dropForeign('onli_items_item_id_fk');
            $table->dropColumn('onli_item_id');
        });

        Schema::dropIfExists('onli_items');
    }
};
