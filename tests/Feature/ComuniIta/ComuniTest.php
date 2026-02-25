<?php

use CarloEusebi\LaravelComuni\Facades\Comuni;

it('returns a collection of comuni', function (): void {
    $result = Comuni::comuni(params: ['pagesize' => 2]);

    expect($result)
        ->toHaveCount(2)
        ->and($result->first())->toBeArray()
        ->toHaveKeys(['codice', 'nome', 'nomeStraniero', 'cap', 'prefisso', 'provincia', 'email', 'pec', 'telefono', 'fax', 'popolazione', 'coordinate']);
});

it('returns comuni filtered by region', function (): void {
    $result = Comuni::comuni(regione: 'Marche');

    expect($result)->toHaveCount(225);
});

it('returns comuni filtered by province', function (): void {
    $result = Comuni::comuni(provincia: 'Pesaro e Urbino');

    expect($result)->toHaveCount(50);
});

it('returns comuni filtered by additional parameters', function (): void {
    $result = Comuni::comuni(provincia: 'Pesaro e Urbino', params: ['q' => 'Fano']);

    expect($result)
        ->toHaveCount(1)
        ->first()->toHaveKey('codiceCatastale', 'D488');
});
