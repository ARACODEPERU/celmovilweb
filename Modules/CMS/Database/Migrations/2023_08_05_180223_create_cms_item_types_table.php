<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\CMS\Entities\CmsItemType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_item_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        CmsItemType::create([
            'description' => 'Imagen'
        ]);
        CmsItemType::create([
            'description' => 'Video'
        ]);
        CmsItemType::create([
            'description' => 'Archivo'
        ]);
        CmsItemType::create([
            'description' => 'Texto'
        ]);
        CmsItemType::create([
            'description' => 'Grupo'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_item_types');
    }
};
