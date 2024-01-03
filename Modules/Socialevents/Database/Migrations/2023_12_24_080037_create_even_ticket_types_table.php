<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Socialevents\Entities\EvenTicketType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('even_ticket_types', function (Blueprint $table) {
            $table->string('id');
            $table->string('description');
            $table->timestamps();
            $table->primary('id');
        });

        EvenTicketType::create([
            'id' => 'GENERAL',
            'description' => 'General'
        ]);
        EvenTicketType::create([
            'id' => 'PREFERENCIAL',
            'description' => 'Preferencial'
        ]);
        EvenTicketType::create([
            'id' => 'VIP',
            'description' => 'Vip'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('even_ticket_types');
    }
};
