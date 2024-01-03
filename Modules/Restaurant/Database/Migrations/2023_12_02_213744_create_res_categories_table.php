<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Restaurant\Entities\ResCategory;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('res_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('description');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('res_categories')->onDelete('cascade');
        });

        ResCategory::create([
            'description' => 'Comidas',
            'status' => true,
        ]);

        ResCategory::create([
            'description' => 'Bebidas',
            'status' => true,
        ]);

        ResCategory::create([
            'description' => 'Entradas',
            'status' => true,
        ]);

        ResCategory::create([
            'description' => 'Frias',
            'status' => true,
            'category_id' => 2
        ]);

        ResCategory::create([
            'description' => 'Calientes',
            'status' => true,
            'category_id' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_categories');
    }
};
