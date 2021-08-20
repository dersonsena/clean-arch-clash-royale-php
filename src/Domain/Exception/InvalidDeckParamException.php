<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

final class InvalidDeckParamException extends DomainException
{
    public static function requiredNumberOfDecks(): self
    {
        return new self(
            sprintf("You should provide 2 decks to do a battle")
        );
    }

    public static function samePlayer(): self
    {
        return new self(
            sprintf("You cannot provide the same player in battle")
        );
    }

    public static function unfairBattle(): self
    {
        return new self(
            sprintf("Unfair battle between players")
        );
    }
}