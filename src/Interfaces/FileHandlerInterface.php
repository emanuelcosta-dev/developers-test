<?php

declare(strict_types=1);

namespace NeufferTest\Interfaces;

interface FileHandlerInterface
{
    /**
     * Read CSV file and return generator of data rows
     */
    public function readCsv(string $filePath): \Generator;

    /**
     * Write calculation result to CSV file
     */
    public function writeResult(string $filePath, int $firstNumber, int $secondNumber, int|float $result): void;

    /**
     * Validate that file exists and is readable
     */
    public function validateFile(string $filePath): void;
}
