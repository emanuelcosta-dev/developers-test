<?php

declare(strict_types=1);

namespace NeufferTest\Exceptions;

class DivisionByZeroException extends \Exception
{
    public function __construct(string $message = "Division by zero is not allowed", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
