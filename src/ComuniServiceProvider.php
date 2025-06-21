<?php

namespace CarloEusebi\LaravelComuni;

use CarloEusebi\LaravelComuni\Services\ComuniIta;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ComuniServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/comuni.php', 'comuni'
        );

        $this->app->singleton('comuni', fn (): ?\CarloEusebi\LaravelComuni\Services\ComuniIta => match (Config::string('comuni.provider', 'comuni-ita')) {
            'comuni-ita' => new ComuniIta,
            default => null,
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/comuni.php' => config_path('comuni.php'),
        ]);
    }
}
