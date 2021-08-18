<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidCardException;

final class Level
{
    public const MIN_LEVEL = 1;
    public const MAX_LEVEL = 13;
    private int $level;

    public function __construct(int $level)
    {
        if ($level > self::MAX_LEVEL) {
            throw InvalidCardException::levelMaxLimitReached($level);
        }

        if ($level < self::MIN_LEVEL) {
            throw InvalidCardException::levelMinLimitReached($level);
        }

        $this->level = $level;
    }

    public function value(): int
    {
        return $this->level;
    }
}