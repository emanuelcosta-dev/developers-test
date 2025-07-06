<?php

declare(strict_types=1);

namespace NeufferTest\Services;

use NeufferTest\Interfaces\LoggerInterface;
use NeufferTest\Enums\Operation;
use NeufferTest\Exceptions\FileException;

final class Logger implements LoggerInterface
{
    /**
     * Initialize the logger with a log file
     */
    public function __construct(
        private readonly string $logFile = 'log.txt'
    ) {
        $this->initializeLogFile();
    }

    /**
     * Log the start of an operation
     */
    public function logStart(Operation $operation): void
    {
        $this->info("Started {$operation->getDescription()} operation");
    }

    /**
     * Log the completion of an operation
     */
    public function logFinish(Operation $operation): void
    {
        $this->info("Finished {$operation->getDescription()} operation");
    }

    /**
     * Log invalid numbers
     */
    public function logInvalidNumbers(int $firstNumber, int $secondNumber, ?string $reason = null): void
    {
        $message = "Numbers $firstNumber and $secondNumber are wrong";
        if ($reason !== null) {
            $message .= " ($reason)";
        }

        $this->info($message);
    }

    /**
     * Log an informational message
     */
    public function info(string $message): void
    {
        $this->writeLog($message, 'INFO');
    }

    /**
     * Log an error message
     */
    public function error(string $message): void
    {
        $this->writeLog($message, 'ERROR');
    }

    /**
     * Initialize log file by clearing it if it exists
     */
    private function initializeLogFile(): void
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }

    /**
     * Write a message to the log file
     */
    private function writeLog(string $message, string $level): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message\n";

        $handle = fopen($this->logFile, 'a');
        if ($handle === false) {
            throw new FileException("Could not open log file: {$this->logFile}");
        }

        try {
            fwrite($handle, $logEntry);
        } finally {
            fclose($handle);
        }
    }
}
