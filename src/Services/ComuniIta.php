<?php

namespace CarloEusebi\LaravelComuni\Services;

use CarloEusebi\LaravelComuni\Comune;
use CarloEusebi\LaravelComuni\Contracts\Comuni;
use CarloEusebi\LaravelComuni\Exceptions\InvalidParameterCombinationException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

/**
 * @see https://github.com/Samurai016/Comuni-ITA
 *
 * @internal
 *
 * @template Provincia of array{name: string, sigla: string, codice: string, regione:string}
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
     * @return Collection<int, string|array{
     *     codice: string,
     *     nome: string,
     *     nomeStranier: string|null,
     *     codiceCatastale: string,
     *     cap: string,
     *     prefisso: string,
     *     provincia: Provincia,
     *     email: string|null,
     *     pec: string|null,
     *     telefono: string|null,
     *     fax: string|null,
     *     popolazione: int,
     *     coordinate: array{lat: float, lng: float}
     * }>
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
            callback: fn (): \Illuminate\Support\Collection => collect($this->makeRequest($endpoint, $params))
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
     * @return Collection<int, Provincia>
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
            callback: fn (): \Illuminate\Support\Collection => collect($this->makeRequest($endpoint, $params))
        );
    }

    /**
     * @param  array{
     *     page?: int<1, max>,
     *     pagesize?: int<0, 500>,
     *     nome?: string,
     * }  $params
     * @return Collection<int, string>
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
            callback: fn (): \Illuminate\Support\Collection => collect($this->makeRequest($endpoint, $params))
        );
    }

    /**
     * @param  array<string, mixed>  $parms
     * @return list<string|array<string, mixed>>
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    private function makeRequest(string $endpoints, array $parms = []): array
    {
        return Http::get($endpoints, $parms)
            ->throw()
            ->json();
    }

    public function cap(string $cap): ?Collection
    {
        /** @var array<string, mixed> $data */
        $data = json_decode(file_get_contents(__DIR__.'/../../resources/comuni.json') ?: '', true);

        $matches = Arr::where($data, fn ($value): bool => in_array($cap, $value['cap']));

        return filled($matches)
            ? collect($matches)->map(fn (array $match): \CarloEusebi\LaravelComuni\Comune => Comune::make($match))
            : null;
    }
}
