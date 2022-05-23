<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    use HasFactory;
    use SoftDeletes;
    use Taggable;

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    public function scopeLatest(Builder $qb)
    {
        return $qb->orderByDesc(static::CREATED_AT);
    }

    public function scopeMostCommented(Builder $qb)
    {
        return $qb->withCount('comments')->orderByDesc('comments_count');
    }

    public function scopeLatestWithRelations(Builder $qb)
    {
        return $qb->latest()->withCount('comments')->with('user')->with('tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();
    }
}
