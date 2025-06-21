<?php

namespace CarloEusebi\LaravelComuni\Services;

use CarloEusebi\LaravelComuni\Contracts\Comuni;
use CarloEusebi\LaravelComuni\Exceptions\InvalidParameterCombinationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

/**
 * @see https://github.com/Samurai016/Comuni-ITA
 */
class ComuniIta implements Comuni
{
    private const BASE_URL = 'https://axqvoqvbfjpaamphztgd.functions.supabase.co/';

    /**
     * @param  array{
     *     page?: int<1, max>,
     *     pagesize?: int<0, 500>,
     *     onlyname?: bool,
     *     onlyforeignname?: bool,
     *     nome?: string,
     *     codice?: string,
     *     codiceCatastale?: string,
     *     cap?: string,
     * }  $params
     *
     * @throws InvalidParameterCombinationException
     */
    public function comuni(?string $regione = null, ?string $provincia = null, array $params = []): Collection
    {
        if ($regione !== null && $provincia !== null) {
            throw new InvalidParameterCombinationException;
        }

        $endpoint = self::BASE_URL.'/comuni';
        if ($provincia !== null && $provincia !== '' && $provincia !== '0') {
            $endpoint .= '/provincia/'.$provincia;
        } elseif ($regione !== null && $regione !== '' && $regione !== '0') {
            $endpoint .= '/'.$regione;
        }

        return Cache::flexible(
            key: Config::string('comuni.cache.prefix', '').$endpoint.'-'.json_encode($params),
            ttl: [
                Config::integer('comuni.cache.stale', 30) * 60 * 24,
                Config::integer('comuni.cache.ttl', 60) * 60 * 24,
            ],
            callback: function () use ($endpoint, $params) {
                /** @var list<string|array<string, mixed>> $comuni */
                $comuni = Http::get($endpoint, $params)->json();

                return collect($comuni);
            }
        );
    }

    /**
     * @param  array{
     *     page?: int<1, max>,
     *     pagesize?: int<0, 500>,
     *     onlyname?: bool,
     *     onlyforeignname?: bool,
     *     nome?: string,
     *     codice?: string,
     *     sigla?: string,
     * }  $params
     */
    public function province(?string $regione = null, array $params = []): Collection
    {
        $endpoint = self::BASE_URL.'/province';

        if ($regione !== null && $regione !== '' && $regione !== '0') {
            $endpoint .= '/'.$regione;
        }

        return Cache::flexible(
            key: Config::string('comuni.cache.prefix', '').$endpoint.'-'.json_encode($params),
            ttl: [
                Config::integer('comuni.cache.stale', 30) * 60 * 24,
                Config::integer('comuni.cache.ttl', 60) * 60 * 24,
            ],
            callback: function () use ($endpoint, $params) {
                /** @var list<string| array<string, string>> $province */
                $province = Http::get($endpoint, $params)->json();

                return collect($province);
            }
        );
    }

    /**
     * @param  array{
     *     page?: int<1, max>,
     *     pagesize?: int<0, 500>,
     *     nome?: string,
     * }  $params
     */
    public function regioni(array $params = []): Collection
    {
        $endpoint = self::BASE_URL.'/regioni';

        return Cache::flexible(
            key: Config::string('comuni.cache.prefix', '').$endpoint.'-'.json_encode($params),
            ttl: [
                Config::integer('comuni.cache.stale', 30) * 60 * 24,
                Config::integer('comuni.cache.ttl', 60) * 60 * 24,
            ],
            callback: function () use ($endpoint, $params) {
                /** @var list<string> $regions */
                $regions = Http::get($endpoint, $params)->json();

                return collect($regions);
            }
        );
    }
}
