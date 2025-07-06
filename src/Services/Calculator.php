<?php

declare(strict_types=1);

namespace NeufferTest\Services;

use NeufferTest\Interfaces\CalculatorInterface;
use NeufferTest\Enums\Operation;
use NeufferTest\Exceptions\DivisionByZeroException;

final readonly class Calculator implements CalculatorInterface
{
    public function calculate(int $firstNumber, int $secondNumber, Operation $operation): int|float
    {
        return match ($operation) {
            Operation::PLUS => $firstNumber + $secondNumber,
            Operation::MINUS => $firstNumber - $secondNumber,
            Operation::MULTIPLY => $firstNumber * $secondNumber,
            Operation::DIVISION => $this->divide($firstNumber, $secondNumber),
        };
    }

    public function isValidResult(int|float $result): bool
    {
        return $result > 0;
    }

    private function divide(int $dividend, int $divisor): float
    {
        if ($divisor === 0) {
            throw new DivisionByZeroException(
                "Division by zero is not allowed: $dividend / $divisor"
            );
        }

        return $dividend / $divisor;
    }
}
