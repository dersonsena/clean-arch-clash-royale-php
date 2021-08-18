<?php

namespace App\Domain\UseCase\CreateDeck;

use RuntimeException;

/**
 * @property-read string|int $id
 * @property-read PlayerModel $player
 * @property-read float $elixirAverage
 */
final class OutputData
{
    private string|int $id;
    private PlayerModel $player;
    private float $elixirAverage;

    private function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->player = $values['player'];
        $this->elixirAverage = $values['elixirAverage'];
    }

    public static function create(array $values): self
    {
        $values['id'] = (int)$values['id'];
        return new OutputData($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Create Deck Output Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}