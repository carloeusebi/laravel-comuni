<?php

namespace CarloEusebi\LaravelComuni\Facades;

use CarloEusebi\LaravelComuni\Comune;
use CarloEusebi\LaravelComuni\Testing\Fakes\ComuniItaFake;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection<int, mixed> comuni(string|null $regione = null, string|null $provincia = null, array<string, mixed> $params = [])
 * @method static Collection<int, mixed> province(string|null $regione = null, array<string, mixed> $params = [])
 * @method static Collection<int, string> regioni(array<string, mixed> $params = [])
 * @method static Collection<int, Comune>|null cap(string $cap)
 */
class Comuni extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'comuni';
    }

    public static function fake(): \CarloEusebi\LaravelComuni\Contracts\Comuni
    {
        $mock = match (Config::string('comuni.provider', 'comuni-ita')) {
            default => new ComuniItaFake,
        };

        return tap(new $mock, fn ($mock) => static::swap($mock));
    }
}
