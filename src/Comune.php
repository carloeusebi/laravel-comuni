<?php

namespace CarloEusebi\LaravelComuni;

use Illuminate\Support\Arr;

class Comune
{
    public private(set) string $nome;

    public private(set) string $codice;

    /** @var array{codice: string, nome: string} */
    public private(set) array $zona;

    /** @var array{codice: string, nome: string} */
    public private(set) array $regione;

    /** @var array{codice: string, nome: string} */
    public private(set) array $provincia;

    public private(set) string $sigla;

    public private(set) string $codiceCatastale;

    /** @var list<string> */
    public private(set) array $cap;

    public private(set) int $popolazione;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(array $params = [])
    {
        $this->nome = Arr::get($params, 'nome');
        $this->codice = Arr::get($params, 'codice');
        $this->zona = Arr::get($params, 'zona');
        $this->regione = Arr::get($params, 'regione');
        $this->provincia = Arr::get($params, 'provincia');
        $this->sigla = Arr::get($params, 'sigla');
        $this->codiceCatastale = Arr::get($params, 'codiceCatastale');
        $this->cap = Arr::get($params, 'cap');
        $this->popolazione = Arr::get($params, 'popolazione');
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public static function make(array $params = []): self
    {
        return new self($params);
    }
}
