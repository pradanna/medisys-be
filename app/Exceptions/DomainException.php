<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DomainException extends Exception
{
    public function __construct(string $message = "", int $code = 500, ?Throwable $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}
