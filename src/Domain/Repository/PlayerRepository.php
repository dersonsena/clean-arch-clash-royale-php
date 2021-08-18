<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Deck\Player;
use App\Domain\Entity\Deck\PlayerCard;

interface PlayerRepository
{
    public function getById(int $playerId): Player;

    /**
     * @param int[] $cardIdList
     * @return PlayerCard[]
     */
    public function getCardsByIdList(array $cardIdList): array;
}