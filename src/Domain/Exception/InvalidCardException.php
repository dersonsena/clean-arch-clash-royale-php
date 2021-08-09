<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\Entity\Deck\Card;
use DomainException;

final class InvalidCardException extends DomainException
{
    public static function levelMaxLimitReached(int $givenLevel)
    {
        return new self(
            sprintf('Card level must be less than %s, %s was given', Card::MAX_LEVEL, $givenLevel)
        );
    }

    public static function levelMinLimitReached(int $givenLevel)
    {
        return new self(
            sprintf('Card level must be greater than %s, %s was given', Card::MIN_LEVEL, $givenLevel)
        );
    }

    public static function elixirMaxLimitReached(int $givenElixir)
    {
        return new self(
            sprintf('Card elixir must be less than %s, %s was given', Card::MAX_ELIXIR, $givenElixir)
        );
    }

    public static function elixirMinLimitReached(int $givenElixir)
    {
        return new self(
            sprintf('Card elixir must be greater than %s, %s was given', Card::MIN_ELIXIR, $givenElixir)
        );
    }
}