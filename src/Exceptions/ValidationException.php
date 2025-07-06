<?php

declare(strict_types=1);

namespace NeufferTest\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(string $message = "Validation failed", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
