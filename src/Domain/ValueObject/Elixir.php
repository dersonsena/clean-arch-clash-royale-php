<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidCardException;

final class Elixir
{
    public const MIN_ELIXIR = 1;
    public const MAX_ELIXIR = 9;

    private int $elixir;

    public function __construct(int $elixir)
    {
        if ($elixir > self::MAX_ELIXIR) {
            throw InvalidCardException::elixirMaxLimitReached($elixir);
        }

        if ($elixir < self::MIN_ELIXIR) {
            throw InvalidCardException::elixirMinLimitReached($elixir);
        }

        $this->elixir = $elixir;
    }

    public function value(): int
    {
        return $this->elixir;
    }
}