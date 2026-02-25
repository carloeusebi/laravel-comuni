<?php

use CarloEusebi\LaravelComuni\Facades\Comuni;

it('returns a collection of all regions', function (): void {
    $result = Comuni::regioni();

    expect($result)
        ->toHaveCount(20)
        ->each->toBeString();
});

it('returns regions with pagination parameters', function (): void {
    $result = Comuni::regioni(params: ['pagesize' => 2]);

    expect($result)
        ->toHaveCount(2);
});
