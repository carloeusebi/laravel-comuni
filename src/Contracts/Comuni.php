<?php

namespace CarloEusebi\LaravelComuni\Contracts;

use CarloEusebi\LaravelComuni\Comune;
use Illuminate\Support\Collection;

interface Comuni
{
    /**
     * @param  array<string, mixed>  $params
     * @return Collection<int, mixed>
     */
    public function comuni(
        ?string $regione = null,
        ?string $provincia = null,
        array $params = [],
    ): Collection;

    /**
     * @param  array<string, mixed>  $params
     * @return Collection<int, mixed>
     */
    public function province(?string $regione, array $params = []): Collection;

    /**
     * @param  array<string, mixed>  $params
     * @return Collection<int, string>
     */
    public function regioni(array $params = []): Collection;

    /**
     * @return Collection<int, Comune>|null
     */
    public function cap(string $cap): ?Collection;
}
