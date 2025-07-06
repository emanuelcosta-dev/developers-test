<?php

declare(strict_types=1);

namespace NeufferTest;

use NeufferTest\Interfaces\CalculatorInterface;
use NeufferTest\Interfaces\FileHandlerInterface;
use NeufferTest\Interfaces\LoggerInterface;
use NeufferTest\Enums\Operation;
use NeufferTest\Exceptions\DivisionByZeroException;
use NeufferTest\Services\Calculator;
use NeufferTest\Services\FileHandler;
use NeufferTest\Services\Logger;
use NeufferTest\Services\Validator;

final class Application
{
    private const RESULT_FILE = 'result.csv';

    public function __construct(
        private readonly CalculatorInterface $calculator = new Calculator(),
        private readonly FileHandlerInterface $fileHandler = new FileHandler(),
        private readonly LoggerInterface $logger = new Logger(),
        private readonly Validator $validator = new Validator(),
    ) {
        $this->initializeResultFile();
    }

    /**
     * Run the application with command line arguments
     */
    public function run(array $options): void
    {
        try {
            $config = $this->validator->validateArguments($options);
            $this->processFile($config['operation'], $config['file']);
        } catch (\Throwable $e) {
            $this->logger->error("Application error: {$e->getMessage()}");
            echo "Error: {$e->getMessage()}\n";
            exit(1);
        }
    }

    /**
     * Process the CSV file with the given operation
     */
    private function processFile(Operation $operation, string $filePath): void
    {
        $this->logger->logStart($operation);

        try {
            $this->fileHandler->validateFile($filePath);

            $processedCount = 0;
            $validResultsCount = 0;
            $invalidResultsCount = 0;

            foreach ($this->fileHandler->readCsv($filePath) as $numbers) {
                [$firstNumber, $secondNumber] = $numbers;
                $processedCount++;

                try {
                    $result = $this->calculator->calculate($firstNumber, $secondNumber, $operation);

                    if ($this->calculator->isValidResult($result)) {
                        $this->fileHandler->writeResult(self::RESULT_FILE, $firstNumber, $secondNumber, $result);
                        $validResultsCount++;
                    } else {
                        $this->logger->logInvalidNumbers($firstNumber, $secondNumber, 'result <= 0');
                        $invalidResultsCount++;
                    }
                } catch (DivisionByZeroException $e) {
                    $this->logger->logInvalidNumbers($firstNumber, $secondNumber, 'division by zero');
                    $invalidResultsCount++;
                }
            }

            $this->logSummary($processedCount, $validResultsCount, $invalidResultsCount);
        } catch (\Throwable $e) {
            $this->logger->error("Processing error: {$e->getMessage()}");
            throw $e;
        } finally {
            $this->logger->logFinish($operation);
        }
    }

    /**
     * Log processing summary
     */
    private function logSummary(int $processed, int $valid, int $invalid): void
    {
        $this->logger->info("Processing complete: $processed total, $valid valid results, $invalid invalid results");
        echo "Processing complete: $processed total, $valid valid results, $invalid invalid results\n";
    }

    /**
     * Initialize result file by clearing it if it exists
     */
    private function initializeResultFile(): void
    {
        if (file_exists(self::RESULT_FILE)) {
            unlink(self::RESULT_FILE);
        }
    }
}
