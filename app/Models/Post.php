<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'inputUrl',
        'id_no',
        'type',
        'caption',
        'url',
        'commentsCount' ,
        'displayUrl',
        'likesCount',
        'videoViewCount',
        'videoUrl',
        'videoPlayCount',
        'ownerFullName',
        'ownerUsername',
        'ownerId',
        'user_id',
        'search_id',
    ];

}
