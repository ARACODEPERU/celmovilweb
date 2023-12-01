<?php

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
        Schema::table('sale_documents', function (Blueprint $table) {
            $table->string('client_type_doc')->nullable();
            $table->string('client_number')->nullable();
            $table->string('client_rzn_social')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_ubigeo_code')->nullable();
            $table->string('client_ubigeo_description')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('invoice_document_name', 150)->nullable()->comment('Nombre del documento (RUC-TIPODOC-SERIE-CORRELATIVO)');
            $table->string('invoice_form_payment')->nullable();
            $table->string('invoice_ubl_version')->nullable();
            $table->string('invoice_type_operation')->nullable();
            $table->string('invoice_type_doc', 2)->nullable();
            $table->string('invoice_serie', 4)->nullable();
            $table->integer('invoice_correlative')->nullable();
            $table->string('invoice_type_currency')->nullable();
            $table->date('invoice_broadcast_date')->nullable()->comment('fecha de emision');
            $table->date('invoice_due_date')->nullable()->comment('fecha de vencimiento');
            $table->dateTime('invoice_send_date')->nullable()->comment('fecha que se envio a sunat');
            $table->decimal('invoice_mto_oper_taxed', 12, 2)->nullable()->comment('monto operaciones onerosas');
            $table->decimal('invoice_mto_oper_unaffected', 12, 2)->nullable()->default(0)->comment('monto operaciones inafectas');
            $table->decimal('invoice_mto_oper_exonerated', 12, 2)->nullable()->default(0)->comment('monto operaciones exoneradas');
            $table->decimal('invoice_mto_oper_export', 12, 2)->nullable()->default(0)->comment('monto operaciones exportación');
            $table->decimal('invoice_mto_oper_other_charges', 12, 2)->nullable()->default(0)->comment('monto operaciones Otros Cargos');
            $table->decimal('invoice_mto_igv', 12, 2)->nullable();
            $table->decimal('invoice_icbper', 12, 2)->nullable();
            $table->decimal('invoice_total_taxes', 12, 2)->nullable()->comment('total impuestos');
            $table->decimal('invoice_value_sale', 12, 2)->nullable()->comment('valor de la venta');
            $table->decimal('invoice_subtotal', 12, 2)->nullable()->comment('valor de la venta');
            $table->decimal('invoice_mto_discount', 12, 2)->nullable()->default(0);
            $table->json('invoice_json_discounts')->nullable()->comment('Catalog. 53 (00: Descuento que afecta la Base Imponible)-cantidad * valor unitario-% descuento');
            $table->decimal('invoice_rounding', 12, 2)->nullable()->comment('redondeo');
            $table->decimal('invoice_mto_imp_sale', 12, 2)->nullable()->comment('monto importe venta');
            $table->string('invoice_legend_code')->nullable();
            $table->string('invoice_legend_description')->nullable();
            $table->string('invoice_sunat_points')->nullable();
            $table->string('invoice_cdr', 500)->nullable();
            $table->string('invoice_xml', 500)->nullable();
            $table->string('invoice_pdf', 500)->nullable();
            $table->string('invoice_response_code', 10)->nullable();
            $table->text('invoice_response_description')->nullable();
            $table->json('invoice_notes')->nullable();
            $table->string('invoice_status', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_documents', function (Blueprint $table) {
            $table->dropColumn('seller_name');
        });
    }
};
