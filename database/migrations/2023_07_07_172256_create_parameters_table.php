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
            $table->char('control_type', 2)->nullable()->comment('in=text,ra=radio,sq=select(query),sa=select(json),ch=checkbox,tx=textarea,rg=range,fl=file');
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
