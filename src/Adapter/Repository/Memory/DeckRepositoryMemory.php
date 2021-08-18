<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Memory;

use App\Domain\Entity\Deck\Deck;
use App\Domain\Entity\Deck\Player;
use App\Domain\Repository\DeckRepository;

final class DeckRepositoryMemory implements DeckRepository
{
    private array $decks = [];
    private int $increment = 1;

    public function save(Player $player, array $playerCards): Deck
    {
        $deck = Deck::create([
            'id' => $this->increment,
            'player' => $player,
            'playerCards' => $playerCards
        ]);

        $this->decks[] = $deck;
        $this->increment++;
        return $deck;
    }
}