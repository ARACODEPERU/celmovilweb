<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('res_category_presentations', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('presentation_id');
            $table->primary(['category_id', 'presentation_id']);
            $table->foreign('category_id')->references('id')->on('res_categories')->onDelete('cascade');
            $table->foreign('presentation_id')->references('id')->on('res_presentations')->onDelete('cascade');
        });

        DB::table('res_category_presentations')->insert([
            ['category_id' => 1, 'presentation_id' => 1],
            ['category_id' => 1, 'presentation_id' => 2],
            ['category_id' => 1, 'presentation_id' => 3],
            ['category_id' => 1, 'presentation_id' => 4],
            ['category_id' => 1, 'presentation_id' => 5],
            ['category_id' => 2, 'presentation_id' => 6],
            ['category_id' => 2, 'presentation_id' => 7],
            ['category_id' => 2, 'presentation_id' => 8],
            ['category_id' => 4, 'presentation_id' => 6],
            ['category_id' => 4, 'presentation_id' => 7],
            ['category_id' => 5, 'presentation_id' => 8],
            ['category_id' => 3, 'presentation_id' => 1]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_category_presentations');
    }
};
