<?php

declare(strict_types=1);

namespace NeufferTest\Interfaces;

use NeufferTest\Enums\Operation;

interface LoggerInterface
{
    /**
     * Log an informational message
     */
    public function info(string $message): void;

    /**
     * Log an error message
     */
    public function error(string $message): void;

    /**
     * Log the start of an operation
     */
    public function logStart(Operation $operation): void;

    /**
     * Log the completion of an operation
     */
    public function logFinish(Operation $operation): void;

    /**
     * Log invalid numbers with optional reason
     */
    public function logInvalidNumbers(int $firstNumber, int $secondNumber, ?string $reason = null): void;
}
