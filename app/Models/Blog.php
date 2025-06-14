<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * @mixin Eloquent
 */
/**
 * @mixin IdeHelperBlog
 */
class Blog extends Model
{
    protected $fillable = [
        "title",
        "author",
        "content",
        "category"
    ];
}
