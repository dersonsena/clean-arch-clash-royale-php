<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

final class InvalidPlayerException extends DomainException
{
    public static function forInvalidNickname(string $givenNickname): self
    {
        return new self(
            sprintf("Invalid nickname format in '%s'. Use letters and numbers only.", $givenNickname)
        );
    }

    public static function notFound(int $playerId)
    {
        return new self(
            sprintf("Player with id '%s' not found.", $playerId)
        );
    }
}