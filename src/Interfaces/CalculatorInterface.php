<?php

declare(strict_types=1);

namespace NeufferTest\Interfaces;

use NeufferTest\Enums\Operation;

interface CalculatorInterface
{
    /**
     * Calculate the result of two numbers using the specified operation
     */
    public function calculate(int $firstNumber, int $secondNumber, Operation $operation): int|float;

    /**
     * Check if the result is valid (greater than 0)
     */
    public function isValidResult(int|float $result): bool;
}
