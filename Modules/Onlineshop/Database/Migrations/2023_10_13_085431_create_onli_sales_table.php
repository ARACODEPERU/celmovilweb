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
        Schema::create('onli_sales', function (Blueprint $table) {
            $table->id();
            $table->string('module_name', 200);
            $table->unsignedBigInteger('person_id');
            $table->decimal('total', 12, 2)->nullable()->nullable();
            $table->decimal('transaction_amount', 12, 2)->nullable();
            $table->string('installments', 3)->nullable();
            $table->string('email')->nullable();
            $table->string('clie_full_name')->nullable();
            $table->string('identification_type')->nullable();
            $table->string('identification_number')->nullable();
            $table->text('token')->nullable();
            $table->string('response_status')->nullable();
            $table->string('response_status_detail')->nullable();
            $table->string('response_id')->nullable();
            $table->string('response_date_approved')->nullable();
            $table->json('response_payer')->nullable();
            $table->string('response_payment_method_id')->nullable();
            $table->string('response_credit_card')->nullable();
            $table->json('response_refunds')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('onli_sales');
    }
};
