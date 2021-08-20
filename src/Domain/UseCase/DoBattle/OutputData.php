<?php

declare(strict_types=1);

namespace App\Domain\UseCase\DoBattle;

use RuntimeException;

/**
 * @property-read string $winnerName
 * @property-read int $winnerTrophy
 * @property-read string $loserName
 * @property-read string $loserTrophy
 */
final class OutputData
{
    private string $winnerName;
    private int $winnerTrophy;
    private string $loserName;
    private string $loserTrophy;

    private function __construct(array $values)
    {
        $this->winnerName = $values['winnerName'];
        $this->winnerTrophy = $values['winnerTrophy'];
        $this->loserName = $values['loserName'];
        $this->loserTrophy = $values['loserTrophy'];
    }

    public static function create(array $values): self
    {
        return new self($values);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Do Battle Output Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}