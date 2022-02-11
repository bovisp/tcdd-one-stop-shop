<?php

namespace App\Exceptions;

class ReadOnlyException extends \RuntimeException
{
    public function __construct(string $method, string $model, int $code = 0, \Throwable $previous = null)
    {
        $message = sprintf(
            'Calling [%s] method on read-only model [%s] is not allowed.',
            $method,
            $model
        );

        parent::__construct($message, $code, $previous);
    }
}
