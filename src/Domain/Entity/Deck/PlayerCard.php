<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use App\Domain\Exception\InvalidCardException;
use RuntimeException;

/**
 * @property-read Card $card
 * @property-read int $level
 * @property-read int $elixir
 */
final class PlayerCard
{
    public const MIN_LEVEL = 1;
    public const MAX_LEVEL = 13;
    public const MIN_ELIXIR = 1;
    public const MAX_ELIXIR = 9;

    private Card $card;
    private int $level;
    private int $elixir;

    private function __construct(array $values)
    {
        $this->card = $values['card'];
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

        return new self($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid PlayerCard Property '%s'", $name));
        }

        return $this->{$name};
    }
}