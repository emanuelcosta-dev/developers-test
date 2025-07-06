<?php

declare(strict_types=1);

namespace NeufferTest\Services;

use NeufferTest\Enums\Operation;
use NeufferTest\Exceptions\ValidationException;

final readonly class Validator
{
    private const MIN_NUMBER = -100;
    private const MAX_NUMBER = 100;

    /**
     * Validate command line arguments
     */
    public function validateArguments(array $options): array
    {
        $action = $this->extractAction($options);
        $file = $this->extractFile($options);

        return [
            'operation' => Operation::fromString($action),
            'file' => $file,
        ];
    }

    /**
     * Validate if numbers are in valid range
     */
    public function validateNumberRange(int $number): bool
    {
        return $number >= self::MIN_NUMBER && $number <= self::MAX_NUMBER;
    }

    /**
     * Validate if both numbers are in valid range
     */
    public function validateNumberPair(int $firstNumber, int $secondNumber): bool
    {
        return $this->validateNumberRange($firstNumber) && $this->validateNumberRange($secondNumber);
    }

    /**
     * Extract action from command line options
     */
    private function extractAction(array $options): string
    {
        $action = $options['a'] ?? $options['action'] ?? null;

        if ($action === null) {
            throw new ValidationException('Action parameter is required. Use --action or -a');
        }

        return $action;
    }

    /**
     * Extract file from command line options
     */
    private function extractFile(array $options): string
    {
        $file = $options['f'] ?? $options['file'] ?? null;

        if ($file === null) {
            throw new ValidationException('File parameter is required. Use --file or -f');
        }

        return $file;
    }
}
