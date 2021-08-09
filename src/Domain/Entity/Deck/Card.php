<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use App\Domain\Exception\InvalidCardException;

final class Card
{
    public const MIN_LEVEL = 1;
    public const MAX_LEVEL = 13;
    public const MIN_ELIXIR = 1;
    public const MAX_ELIXIR = 9;

    public string|int|null $id;
    public string $name;
    public int $level;
    public int $elixir;

    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->name = $values['name'];
        $this->level = $values['level'];
        $this->elixir = $values['elixir'];
    }

    public static function create(array $values): self
    {
        if ($values['level'] > self::MAX_LEVEL) {
            throw InvalidCardException::levelMaxLimitReached($values['level']);
        }

        if ($values['level'] < self::MIN_LEVEL) {
            throw InvalidCardException::levelMinLimitReached($values['level']);
        }

        if ($values['elixir'] > self::MAX_ELIXIR) {
            throw InvalidCardException::elixirMaxLimitReached($values['level']);
        }

        if ($values['elixir'] < self::MIN_ELIXIR) {
            throw InvalidCardException::elixirMinLimitReached($values['level']);
        }

        return new Card($values);
    }
}