<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CMS\Database\factories\CmsTestimonyFactory;

class CmsTestimony extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'item_id',
        'entitie',
        'title',
        'description',
        'image',
        'video',
        'status'
    ];

    protected static function newFactory(): CmsTestimonyFactory
    {
        //return CmsTestimonyFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        // Se ejecuta antes de guardar un nuevo registro o actualizar uno existente
        static::saving(function ($testimony) {
            $testimony->description = htmlspecialchars($testimony->description, ENT_QUOTES);
            $testimony->video = htmlspecialchars($testimony->video, ENT_QUOTES);
        });

        // Se ejecuta después de recuperar un registro de la base de datos
        static::retrieved(function ($testimony) {
            $testimony->description = htmlspecialchars_decode($testimony->description, ENT_QUOTES);
            $testimony->video = htmlspecialchars_decode($testimony->video, ENT_QUOTES);
        });
    }
}
