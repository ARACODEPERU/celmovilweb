<?php

namespace Modules\Restaurant\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Restaurant\Database\factories\ResComandaFactory;

class ResComanda extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'category_id',
        'presentation_id',
        'status'
    ];

    protected static function newFactory(): ResComandaFactory
    {
        //return ResComandaFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ResCategory::class, 'category_id');
    }
    public function presentation(): BelongsTo
    {
        return $this->belongsTo(ResPresentation::class, 'presentation_id');
    }

    public function menus()
    {
        return $this->belongsToMany(ResMenu::class, 'res_menu_comandas', 'comanda_id', 'menu_id');
    }
}
