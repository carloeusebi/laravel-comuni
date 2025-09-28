<?php

use CarloEusebi\LaravelComuni\Exceptions\InvalidParameterCombinationException;
use CarloEusebi\LaravelComuni\Facades\Comuni;

beforeEach(function (): void {
    Comuni::fake();
});

it('returns a collection of comuni', function (): void {
    $fakeResponse = Comuni::comuni();

    expect($fakeResponse)
        ->toHaveCount(500)
        ->first()->toHaveKeys(['codice', 'nome', 'nomeStraniero', 'cap', 'prefisso', 'provincia', 'email', 'pec', 'telefono', 'fax', 'popolazione', 'coordinate']);
});

it('returns a collection of provinces', function (): void {
    $fakeResponse = Comuni::province();

    expect($fakeResponse)
        ->toHaveCount(107)
        ->first()->toHaveKeys(['nome', 'codice', 'sigla', 'regione']);
});

it('returns a collection of regions', function (): void {
    $fakeResponse = Comuni::regioni();

    expect($fakeResponse)
        ->toHaveCount(20)
        ->first()->toBeString();
});

it('can fake pagesize', function (): void {
    expect(Comuni::comuni(params: ['pagesize' => 2]))->toHaveCount(2);
    expect(Comuni::province(params: ['pagesize' => 2]))->toHaveCount(2);
    expect(Comuni::regioni(params: ['pagesize' => 2]))->toHaveCount(2);
});

it('can fake onlyname', function (): void {
    expect(Comuni::comuni(params: ['pagesize' => 10, 'onlyname' => true]))->each->toBeString();
    expect(Comuni::province(params: ['pagesize' => 10, 'onlyname' => true]))->each->toBeString();
});

it('throws InvalidParameterCombinationException when both regione and provincia are provided', function (): void {
    // This test should throw an exception
    expect(function (): void {
        Comuni::comuni(regione: 'Lazio', provincia: 'Roma');
    })->toThrow(InvalidParameterCombinationException::class);
});

test('cap', function (): void {
    expect(Comuni::cap('61032'))
        ->toBeIterable()
        ->first()
        ->toHaveKey('nome', 'Fano');
});
