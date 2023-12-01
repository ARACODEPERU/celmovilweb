<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HelpLevel extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'index_number', 'status'];

    protected static function newFactory()
    {
        return \Modules\Helpdesk\Database\factories\HelpLevelFactory::new();
    }
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(\App\Models\User::class, HelpLevelUser::class, 'level_id', 'id', 'id', 'user_id');
    }
}
