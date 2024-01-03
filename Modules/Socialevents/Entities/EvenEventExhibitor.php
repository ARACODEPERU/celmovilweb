<?php

namespace Modules\Socialevents\Entities;

use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Socialevents\Database\factories\EvenEventExhibitorFactory;

class EvenEventExhibitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['event_id', 'exhibitor_id'];
    public $timestamps = false;

    protected static function newFactory(): EvenEventExhibitorFactory
    {
        //return EvenEventExhibitorFactory::new();
    }

    public function exhibitor(): HasOne
    {
        return $this->hasOne(Person::class, 'id', 'exhibitor_id');
    }
}
