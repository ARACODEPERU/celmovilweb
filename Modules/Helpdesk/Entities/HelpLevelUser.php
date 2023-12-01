<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpLevelUser extends Model
{
    use HasFactory;

    protected $fillable = ['level_id', 'user_id'];

    protected static function newFactory()
    {
        return \Modules\Helpdesk\Database\factories\HelpLevelUserFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function level(): BelongsTo
    {
        return $this->belongsTo(HelpLevel::class, 'level_id');
    }
}
