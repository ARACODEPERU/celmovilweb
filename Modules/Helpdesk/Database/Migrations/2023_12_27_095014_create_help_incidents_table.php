<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Helpdesk\Entities\HelpIncident;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('help_incidents', function (Blueprint $table) {
            $table->id();
            $table->text('description')->comment('descripcion de la pregunta');
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('help_categories')->onDelete('cascade');
        });

        HelpIncident::create([
            'id'            => 1,
            'description'   => 'Otros',
            'status'        => true,
            'category_id'   => null
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_incidents');
    }
};
