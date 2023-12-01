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
        Schema::table('cms_subscribers', function (Blueprint $table) {
            $table->boolean('read')->default('0');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_subscribers', function (Blueprint $table) {
            $table->dropColumn('message');
            $table->dropColumn('subject');
            $table->dropColumn('read');
        });
    }
};
