<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['content', 'user_id'];

    public function commantable()
    {
        return $this->morphTo(BlogPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $qb)
    {
        return $qb->orderByDesc(static::CREATED_AT);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Comment $comment) {
            if ($comment->commantable_type === BlogPost::class) {
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commantable_id}");
            }
            Cache::tags(['blog-post'])->forget("blog-post-mostCommented");
        });

    }
}
