<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HelpBoard extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'image'];

    protected static function newFactory()
    {
        return \Modules\Helpdesk\Database\factories\HelpBoardFactory::new();
    }

    public function levels(): HasManyThrough
    {
        return $this->hasManyThrough(HelpLevel::class, HelpBoardLevel::class, 'board_id', 'id', 'id', 'level_id');
    }
}
