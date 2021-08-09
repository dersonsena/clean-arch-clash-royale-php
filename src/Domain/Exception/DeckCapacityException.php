<?php

namespace App\Domain\Exception;

use DomainException;

final class DeckCapacityException extends DomainException
{
    public static function capacityExceeded(int $capacity, int $given): self
    {
        return new self(
            sprintf("Deck capacity is '%s' and '%s' was given.", $capacity, $given)
        );
    }
}