<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use DomainException;

final class DeckCardDuplicateException extends DomainException
{
    public static function duplicateCards(): self
    {
        return new self("You can't add a deck with duplicated cards");
    }
}