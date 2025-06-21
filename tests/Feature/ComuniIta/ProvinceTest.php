<?php

use CarloEusebi\LaravelComuni\Facades\Comuni;

it('returns a collection of all provinces', function (): void {
    // Mock HTT
    $result = Comuni::province();

    expect($result)
        ->toHaveCount(107)
        ->each->toHaveKeys(['nome', 'codice', 'sigla', 'regione']);
});

it('returns provinces filtered by region', function (): void {
    $result = Comuni::province('Marche');

    expect($result)
        ->toHaveCount(5);
});

it('returns provinces filtered by additional parameters', function (): void {
    $result = Comuni::province(params: ['nome' => 'Roma']);

    expect($result)
        ->toHaveCount(1)
        ->first()->toHaveKey('nome', 'Roma');
});
