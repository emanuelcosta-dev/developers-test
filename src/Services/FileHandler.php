<?php

declare(strict_types=1);

namespace NeufferTest\Services;

use NeufferTest\Interfaces\FileHandlerInterface;
use NeufferTest\Exceptions\FileException;

final class FileHandler implements FileHandlerInterface
{
    /**
     * Read CSV file and return generator of data rows
     */
    public function readCsv(string $filePath): \Generator
    {
        $this->validateFile($filePath);

        $handle = fopen($filePath, 'r');
        if ($handle === false) {
            throw new FileException("Could not open file: $filePath");
        }

        try {
            while (($line = fgets($handle)) !== false) {
                $numbers = $this->parseCsvLine($line);
                if ($numbers !== null) {
                    yield $numbers;
                }
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Write calculation result to CSV file
     */
    public function writeResult(string $filePath, int $firstNumber, int $secondNumber, int|float $result): void
    {
        $handle = fopen($filePath, 'a');
        if ($handle === false) {
            throw new FileException("Could not open file for writing: $filePath");
        }

        try {
            $line = sprintf("%d;%d;%s\n", $firstNumber, $secondNumber, $this->formatResult($result));
            fwrite($handle, $line);
        } finally {
            fclose($handle);
        }
    }

    /**
     * Validate that file exists and is readable
     */
    public function validateFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new FileException("File does not exist: $filePath");
        }

        if (!is_readable($filePath)) {
            throw new FileException("File is not readable: $filePath");
        }
    }

    /**
     * Parse a CSV line and return array of two integers
     */
    private function parseCsvLine(string $line): ?array
    {
        $line = trim($line);
        if (empty($line)) {
            return null;
        }

        $parts = explode(';', $line);
        if (count($parts) !== 2) {
            return null;
        }

        $firstNumber = (int) trim($parts[0]);
        $secondNumber = (int) trim($parts[1]);

        if (!$this->isValidRange($firstNumber) || !$this->isValidRange($secondNumber)) {
            return null;
        }

        return [$firstNumber, $secondNumber];
    }

    /**
     * Check if number is in valid range (-100 to 100)
     */
    private function isValidRange(int $number): bool
    {
        return $number >= -100 && $number <= 100;
    }

    /**
     * Format result for CSV output
     */
    private function formatResult(int|float $result): string
    {
        if (is_float($result)) {
            return number_format($result, 2, '.', '');
        }

        return (string) $result;
    }
}
