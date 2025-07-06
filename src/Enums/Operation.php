<?php

declare(strict_types=1);

namespace NeufferTest\Enums;

enum Operation: string
{
    case PLUS = 'plus';
    case MINUS = 'minus';
    case MULTIPLY = 'multiply';
    case DIVISION = 'division';

    public function getSymbol(): string
    {
        return match ($this) {
            self::PLUS => '+',
            self::MINUS => '-',
            self::MULTIPLY => '*',
            self::DIVISION => '/',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::PLUS => 'addition',
            self::MINUS => 'subtraction',
            self::MULTIPLY => 'multiplication',
            self::DIVISION => 'division',
        };
    }

    public static function fromString(string $operation): self
    {
        return match (strtolower($operation)) {
            'plus' => self::PLUS,
            'minus' => self::MINUS,
            'multiply' => self::MULTIPLY,
            'division' => self::DIVISION,
            default => throw new \InvalidArgumentException("Unsupported operation: $operation"),
        };
    }
}
