<?php

use CarloEusebi\LaravelComuni\Exceptions\InvalidParameterCombinationException;
use CarloEusebi\LaravelComuni\Facades\Comuni;

it('throws InvalidParameterCombinationException when both regione and provincia are provided', function (): void {
    // This test should throw an exception
    expect(function (): void {
        Comuni::comuni(regione: 'Lazio', provincia: 'Roma');
    })->toThrow(InvalidParameterCombinationException::class);
});

it('throws InvalidParameterCombinationException with correct message', function (): void {
    // This test verifies the exception message
    try {
        Comuni::comuni(regione: 'Lazio', provincia: 'Roma');
    } catch (InvalidParameterCombinationException $e) {
        expect($e->getMessage())->toBe("Cannot specify both 'regione' and 'provincia' parameters simultaneously");
    }
});
