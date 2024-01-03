<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Helpdesk\Database\factories\HelpIncidentFactory;

class HelpIncident extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'description', 'status', 'category_id'
    ];

    protected static function newFactory(): HelpIncidentFactory
    {
        //return HelpIncidentFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'category_id', 'id');
    }
}
