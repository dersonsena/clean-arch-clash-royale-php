<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use RuntimeException;

/**
 * @property-read int $id
 * @property-read Player $player
 */
final class Deck
{
    private int $id;
    private Player $player;

    /**
     * @var PlayerCard[]
     */
    private array $playerCards;

    private function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->player = $values['player'];
        $this->playerCards = $values['playerCards'];
    }

    public static function create(array $values): self
    {
        $values['id'] = (int)$values['id'];
        return new self($values);
    }

    public function getElixirAverage(): float
    {
        if (empty($this->playerCards)) {
            return 0;
        }

        $elixirList = array_map(fn ($playerCard) => $playerCard->elixir, $this->playerCards);
        return ceil(array_sum($elixirList) / count($elixirList));
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Deck Property '%s'", $name));
        }

        return $this->{$name};
    }
}