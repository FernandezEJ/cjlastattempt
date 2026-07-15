<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'image',
        'title',
        'content',
        'status',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryData()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }
}