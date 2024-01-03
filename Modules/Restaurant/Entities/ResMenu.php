<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Restaurant\Database\factories\ResMenuFactory;

class ResMenu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'description', 'status'
    ];

    protected static function newFactory(): ResMenuFactory
    {
        //return ResMenuFactory::new();
    }
    public function comandas(): HasMany
    {
        return $this->hasMany(ResMenuComanda::class, 'menu_id');
    }
}
