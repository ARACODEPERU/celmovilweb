<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Helpdesk\Database\factories\HelpTicketActivityFactory;

class HelpTicketActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): HelpTicketActivityFactory
    {
        //return HelpTicketActivityFactory::new();
    }
}
