<?php

namespace Modules\Blog\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content_text',
        'imagen',
        'views',
        'likes',
        'url',
        'publicity',
        'status',
        'keywords',
        'short_description',
        'category_id',
        'user_id'
    ];

    protected static function newFactory()
    {
        return \Modules\Blog\Database\factories\BlogArticleFactory::new();
    }

    public function getContentTextAttribute($value)
    {
        return html_entity_decode($value, ENT_QUOTES, "UTF-8");
    }
    public function getImagenAttribute($value)
    {
        return ($value != 'img/imagen-no-disponible.jpg' ? asset('storage/' . $value) : asset($value));
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
