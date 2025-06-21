<?php

use CarloEusebi\LaravelComuni\Facades\Comuni;
use Illuminate\Support\Collection;

it('returns empty collection when province name is wrong', function (): void {
    $result = Comuni::comuni(provincia: 'WRONG_PROVINCE');

    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result)->toBeEmpty();
});

it('returns empty collection when region name is wrong', function (): void {
    $result = Comuni::comuni(regione: 'WRONG_REGION');

    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result)->toBeEmpty();
});

it('returns empty collection when province name is wrong in province method', function (): void {
    $result = Comuni::province('WRONG_REGION');

    expect($result)->toBeInstanceOf(Collection::class)
        ->and($result)->toBeEmpty();
});
