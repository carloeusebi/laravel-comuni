<?php

use CarloEusebi\LaravelComuni\Comune;
use CarloEusebi\LaravelComuni\Facades\Comuni;

it('can retrieve a comune given a cap', function (): void {
    $comuni = Comuni::cap('61032');

    expect($comuni)
        ->toBeIterable()
        ->and($comuni->first())
        ->toBeInstanceOf(Comune::class)
        ->nome->toBe('Fano');
});

it('returns null if the cap is not found', function (): void {
    expect(Comuni::cap('invalid'))
        ->toBeNull();
});
