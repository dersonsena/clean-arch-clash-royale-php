<?php

declare(strict_types=1);

namespace App\Domain\UseCase\DoBattle;

use RuntimeException;

/**
 * @property-read int $deckId1
 * @property-read int $deckId2
 */
final class InputData
{
    private int $deckId1;
    private int $deckId2;

    private function __construct(array $values)
    {
        $this->deckId1 = $values['deckId1'];
        $this->deckId2 = $values['deckId2'];
    }

    public static function create(array $values): self
    {
        return new self($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Do Battle Input Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}