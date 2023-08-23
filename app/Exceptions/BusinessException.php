<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class BusinessException extends Exception
{
    public function __construct(string $message = "Internal Server Error", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
