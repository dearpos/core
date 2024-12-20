<?php

namespace Dearpos\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dearpos\Core\Core
 */
class Core extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Dearpos\Core\Core::class;
    }
}
