<?php

namespace CarloEusebi\LaravelComuni\Exceptions;

use Exception;

class InvalidParameterCombinationException extends Exception
{
    public function __construct(string $message = "Cannot specify both 'regione' and 'provincia' parameters simultaneously", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
