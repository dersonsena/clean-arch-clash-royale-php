<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Deck\Deck;
use App\Domain\Entity\Deck\Player;
use App\Domain\Entity\Deck\PlayerCard;

interface DeckRepository
{
    /**
     * @param int $capacity
     * @param Player $player
     * @param PlayerCard[] $playerCards
     * @return mixed
     */
    public function save(int $capacity, Player $player, array $playerCards): Deck;
    public function getById(int $deckId): ?Deck;
}