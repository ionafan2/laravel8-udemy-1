<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Tag;

trait Taggable
{
    protected static function bootTaggable()
    {
        static::updating(function ($model) {
            $model->tags()->sync(
                static::findTagsInContent($model->content)
            );
        });

        static::created(function ($model) {
            $model->tags()->sync(
                static::findTagsInContent($model->content)
            );
        });
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }

    public static function findTagsInContent($content)
    {
        preg_match_all('/@(\w+)/m', $content, $tags);

        return Tag::whereIn('name', $tags[1] ?? [])->get();
    }
}
