<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use App\Domain\ValueObject\Elixir;
use App\Domain\ValueObject\Level;
use RuntimeException;

/**
 * @property-read Card $card
 * @property-read int $level
 * @property-read int $elixir
 */
final class PlayerCard
{
    private Card $card;
    private Level $level;
    private Elixir $elixir;

    private function __construct(array $values)
    {
        $this->card = $values['card'];
        $this->level = $values['level'];
        $this->elixir = $values['elixir'];
    }

    public static function create(array $values): self
    {
        $values['elixir'] = new Elixir($values['elixir']);
        $values['level'] = new Level($values['level']);
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