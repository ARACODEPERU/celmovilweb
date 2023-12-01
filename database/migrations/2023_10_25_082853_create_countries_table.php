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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('country_code', 8)->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('countries')->insert([
            [
                'description' => 'Perú',
                'country_code' => null,
                'image' => 'img/banderas/peru.png',
                'icon' => 'img/banderas/peru32x32.png'
            ],
            [
                'description' => 'Bolivia',
                'country_code' => null,
                'image' => 'img/banderas/bolivia.png',
                'icon' => 'img/banderas/bolivia32x32.png'
            ],
            [
                'description' => 'Ecuador',
                'country_code' => null,
                'image' => 'img/banderas/ecuador.png',
                'icon' => 'img/banderas/ecuador32x32.png'
            ],
            [
                'description' => 'Colombia',
                'country_code' => null,
                'image' => 'img/banderas/colombia.png',
                'icon' => 'img/banderas/colombia32x32.png'
            ],
            [
                'description' => 'Mexico',
                'country_code' => null,
                'image' => 'img/banderas/mexico.png',
                'icon' => 'img/banderas/mexico32x32.png'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
