<?php

namespace Modules\CMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'email', 'phone', 'client_ip', 'read', 'subject', 'message'
    ];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\CmsSubscriberFactory::new();
    }
}
