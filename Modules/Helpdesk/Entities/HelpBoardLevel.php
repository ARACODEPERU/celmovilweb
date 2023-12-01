<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HelpBoardLevel extends Model
{
    use HasFactory;

    protected $fillable = ['board_id', 'level_id', 'index_number'];

    protected static function newFactory()
    {
        return \Modules\Helpdesk\Database\factories\HelpBoardLevelFactory::new();
    }
}
