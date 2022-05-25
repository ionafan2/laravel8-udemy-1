<?php

/**
 * BCP
 *
 * @package ${NAMESPACE}
 * @license Proprietary Software
 * @author  Pavlo Cherniavskyi
 */

declare(strict_types=1);

namespace App\Facades;

use App\Contracts\CounterContract;
use Illuminate\Support\Facades\Facade;


/**
 * A Facade do contract
 * @method static int increment(string $key, array $tags = null)
 */
class CounterFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CounterContract::class;
    }

}
