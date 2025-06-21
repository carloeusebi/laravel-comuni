<?php

namespace CarloEusebi\LaravelComuni\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection<int, mixed> comuni(string|null $regione, string|null $provincia)
 * @method static Collection<int, mixed> province(string|null $regione)
 * @method static Collection<int, string> regioni()
 */
class Comuni extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'comuni';
    }
}
