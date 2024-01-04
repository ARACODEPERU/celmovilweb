<?php

use App\Models\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->string('parameter_code')->unique();
            $table->string('description');
            $table->char('control_type', 3)->nullable()->comment('in=text,sq=select(query),sa=select(json),chq=checkbox(query),chj=checkbox(json),tx=textarea,rgq=range(query),rgj=range(json),fl=file');
            $table->text('json_query_data')->nullable();
            $table->text('value_default')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Parameter::create([
            'parameter_code'    => 'P000001',
            'description'       => 'Valor de IGV',
            'control_type'      => 'in',
            'json_query_data'   => null,
            'value_default'     => '18'
        ]);
        Parameter::create([
            'parameter_code'    => 'P000002',
            'description'       => 'Tipo de operacion Venta - Catalog. 51 Sunat',
            'control_type'      => 'se',
            'json_query_data'   => null,
            'value_default'     => '0101'
        ]);


        Parameter::create([
            'parameter_code'    => 'P000003',
            'description'       => 'versión ubl',
            'control_type'      => 'in',
            'json_query_data'   => null,
            'value_default'     => '2.1'
        ]);

        Parameter::create([
            'parameter_code'    => 'P000004',
            'description'       => 'impuesto a la bolsa plástica',
            'control_type'      => 'in',
            'json_query_data'   => null,
            'value_default'     => '0.20'
        ]);

        Parameter::create([
            'parameter_code'    => 'P000006',
            'description'       => 'pruebas sunat',
            'control_type'      => 'in',
            'json_query_data'   => null,
            'value_default'     => null
        ]);

        Parameter::create([
            'parameter_code'    => 'P000007',
            'description'       => 'produccion sunat',
            'control_type'      => 'in',
            'json_query_data'   => null,
            'value_default'     => null
        ]);
        Parameter::create([
            'parameter_code'    => 'P000008',
            'description'       => 'Tipo de afectación del IGV por defecto compras y ventas',
            'control_type'      => 'se',
            'json_query_data'   => null,
            'value_default'     => '10'
        ]);

        Parameter::create([
            'parameter_code'    => 'P000009',
            'description'       => 'Tipo de negocio o empresa',
            'control_type'      => 'in',
            'json_query_data'   => '[{"value": "1","label":"Cursos"},{"value": "2","label":"Productos"}]',
            'value_default'     => 1
        ]);

        Parameter::create([
            'parameter_code'    => 'P000010',
            'description'       => 'Token de Editor en linea Tiny',
            'control_type'      => 'tx',
            'json_query_data'   => null,
            'value_default'     => 'xmpsrss1dh49by6nnf83jicfv477cz0o31h0xu3ejsnnhsnz'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
