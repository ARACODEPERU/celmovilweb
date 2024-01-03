<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Restaurant\Database\factories\ResMenuComandaFactory;

class ResMenuComanda extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'menu_id', 'comanda_id'
    ];

    protected static function newFactory(): ResMenuComandaFactory
    {
        //return ResMenuComandaFactory::new();
    }

    public function comanda(): HasOne
    {
        return $this->hasOne(ResComanda::class, 'id', 'comanda_id');
    }
}
