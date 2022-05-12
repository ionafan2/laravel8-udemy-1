<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    use HasFactory;
    use SoftDeletes;

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $qb)
    {
        return $qb->orderByDesc(static::CREATED_AT);
    }

    public function scopeMostCommented(Builder $qb)
    {
        return $qb->withCount('comments')->orderByDesc('comments_count');
    }

    public static function boot()
    {
        parent::boot();

//        static::addGlobalScope(new LatestScope());

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
