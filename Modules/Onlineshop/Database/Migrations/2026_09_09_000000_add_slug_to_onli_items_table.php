<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Agregar columna slug si no existe
        if (!Schema::hasColumn('onli_items', 'slug')) {
            Schema::table('onli_items', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
            });
        }

        // Generar slugs para productos existentes
        $items = DB::table('onli_items')->whereNull('slug')->orWhere('slug', '')->get();
        foreach ($items as $item) {
            $baseSlug = Str::slug($item->name);
            $slug = $baseSlug;
            $counter = 1;

            // Verificar unicidad
            while (DB::table('onli_items')->where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            DB::table('onli_items')->where('id', $item->id)->update(['slug' => $slug]);
        }

        // Agregar constraint UNIQUE si no existe
        $indexes = DB::select('SHOW INDEX FROM onli_items WHERE Key_name = ?', ['onli_items_slug_unique']);
        if (empty($indexes)) {
            Schema::table('onli_items', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onli_items', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
