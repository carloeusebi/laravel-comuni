<?php

namespace CarloEusebi\LaravelComuni\Testing\Fakes;

use CarloEusebi\LaravelComuni\Contracts\Comuni;
use CarloEusebi\LaravelComuni\Exceptions\InvalidParameterCombinationException;
use CarloEusebi\LaravelComuni\Services\ComuniIta;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @internal
 *
 * @see ComuniIta
 */
class ComuniItaFake implements Comuni
{
    /**
     * @throws InvalidParameterCombinationException
     */
    public function comuni(?string $regione = null, ?string $provincia = null, array $params = []): Collection
    {
        if ($regione !== null && $provincia !== null) {
            throw new InvalidParameterCombinationException;
        }

        $pageSize = Arr::get($params, 'pagesize', 500);
        if (Arr::has($params, 'onlyname')) {
            return collect(array_fill(0, $pageSize, fake()->city()));
        }

        return collect(array_fill(0, $pageSize, $this->fakeComune()));
    }

    public function province(?string $regione = null, array $params = []): Collection
    {
        $pageSize = Arr::get($params, 'pagesize', 107);

        if (Arr::has($params, 'onlyname')) {
            return collect(array_fill(0, $pageSize, fake()->city()));
        }

        return collect(array_fill(0, $pageSize, $this->fakeProvincia()));
    }

    public function regioni(array $params = []): Collection
    {
        return collect([
            'Abruzzo',
            'Basilicata',
            'Calabria',
            'Campania',
            'Emilia Romagna',
            'Friuli Venezia Giulia',
            'Lazio',
            'Liguria',
            'Lombardia',
            'Marche',
            'Molise',
            'Piemonte',
            'Puglia',
            'Sardegna',
            'Sicilia',
            'Toscana',
            'Trentino Alto Adige',
            'Umbria',
            "Valle d'Aosta",
            'Veneto',
        ])->take(Arr::get($params, 'pagesize', 20));
    }

    /**
     * @return array<string, string|int|array<string, string>|array{lat:float, lng:float}|null>
     */
    private function fakeComune(): array
    {
        return [
            'codice' => fake()->numerify('#####'),
            'nome' => fake()->city(),
            'nomeStraniero' => null,
            'codiceCatastale' => fake()->regexify('[A-Z]{1}[0-9]{3}'),
            'cap' => fake()->numerify('#####'),
            'prefisso' => fake()->numerify(),
            'provincia' => $this->fakeProvincia(),
            'email' => fake()->email(),
            'pec' => fake()->email(),
            'telefono' => fake()->phoneNumber(),
            'fax' => fake()->phoneNumber(),
            'popolazione' => fake()->numberBetween(1000, 1000000),
            'coordinate' => [
                'lat' => fake()->latitude(),
                'lng' => fake()->longitude(),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function fakeProvincia(): array
    {
        return [
            'nome' => fake()->city(),
            'sigla' => fake()->regexify('[A-Z]{2}'),
            'codice' => fake()->numerify('#####'),
            'regione' => fake()->city(),
        ];
    }
}
