<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Restaurant\Entities\ResPresentation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('res_presentations', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('description');
            $table->timestamps();
        });

        ResPresentation::create([
            'icon'  => 'img/esquema-de-plato-y-cubiertos.png',
            'description' => 'Plato Personal'
        ]);

        ResPresentation::create([
            'icon'  => 'img/esquema-de-plato-y-cubiertos.png',
            'description' => 'Plato Personal Mediano'
        ]);

        ResPresentation::create([
            'icon'  => 'img/esquema-de-plato-y-cubiertos.png',
            'description' => 'Plato Personal Grande'
        ]);

        ResPresentation::create([
            'icon'  => 'img/comida.png',
            'description' => 'Fuente Mediana'
        ]);

        ResPresentation::create([
            'icon'  => 'img/comida.png',
            'description' => 'Fuente Familiar'
        ]);

        ResPresentation::create([
            'icon'  => 'img/baso-agua.png',
            'description' => 'Basó'
        ]);
        ResPresentation::create([
            'icon'  => 'img/jarra-de-agua.png',
            'description' => 'Jarra'
        ]);
        ResPresentation::create([
            'icon'  => 'img/taza-de-te.png',
            'description' => 'Taza'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('res_presentations');
    }
};
