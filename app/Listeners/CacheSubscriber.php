<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            CacheHit::class,
            '\App\Listeners\CacheSubscriber@handleCacheHit'
        );

        $events->listen(
            CacheMissed::class,
            '\App\Listeners\CacheSubscriber@handleCacheMissed'
        );
    }

    /**
     * Handle the event.
     *
     * @param CacheHit $event
     * @return void
     */
    public function handleCacheHit(CacheHit $event)
    {
        //Log::info($event->key . " cache HIT");
    }

    /**
     * Handle the event.
     *
     * @param CacheMissed $event
     * @return void
     */
    public function handleCacheMissed(CacheMissed $event)
    {
        //Log::info($event->key . " cache Missed");
    }
}
