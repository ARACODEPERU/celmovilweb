<?php

namespace Modules\Socialevents\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Socialevents\Database\factories\EvenEventLocalFactory;

class EvenEventLocal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['event_id', 'local_id'];
    public $timestamps = false;

    protected static function newFactory(): EvenEventLocalFactory
    {
        //return EvenEventLocalFactory::new();
    }
    public function local(): HasOne
    {
        return $this->hasOne(EvenLocal::class, 'id', 'local_id');
    }
}
