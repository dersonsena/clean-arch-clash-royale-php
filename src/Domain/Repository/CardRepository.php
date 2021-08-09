<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entities\Deck\Card;

interface CardRepository
{
    public function createCardIfNotExists(Card $card): Card;
}