<?php

namespace Modules\Sales\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'summary_name',
        'generation_date',
        'summary_date',
        'correlative',
        'sunat_points',
        'ticket',
        'cdr',
        'xml',
        'pdf',
        'response_code',
        'response_description',
        'notes',
        'status',
        'user_id',
        'anio'
    ];

    protected static function newFactory()
    {
        return \Modules\Sales\Database\factories\SaleSummaryFactory::new();
    }

    // Definimos el evento "creating"
    protected static function boot()
    {
        parent::boot();

        static::created(function ($summary) {
            // Verificamos si la tabla está vacía

            $lastSummary = static::latest()->first();
            $correlativo = null;
            if (!$lastSummary) {
                // Si está vacía, establecemos el correlativo inicial a '00001'
                $correlativo = '00001';
            } else {

                // Si no está vacía, incrementamos el correlativo del último registro
                $lastCorrelativo = SaleSummary::where('id', '<>', $lastSummary->id)->max('correlative');
                $correlativo = str_pad((int) $lastCorrelativo + 1, 5, '0', STR_PAD_LEFT);
            }
            //dd($correlativo);
            // Actualizamos el campo "correlativo" del registro recién insertado
            $summary->update(['correlative' => $correlativo]);
        });
    }
}
