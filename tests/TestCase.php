<?php

namespace Tests;

use CarloEusebi\LaravelComuni\ComuniServiceProvider;
use CarloEusebi\LaravelComuni\Facades\Comuni;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @return array<string, class-string<Facade>>
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Comuni' => Comuni::class,
            'Http' => Http::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('cache.default', 'array');
    }

    /**
     * @return list<class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ComuniServiceProvider::class,
        ];
    }
}
