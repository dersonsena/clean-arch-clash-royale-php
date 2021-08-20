<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Memory;

use App\Domain\Entity\Deck\Deck;
use App\Domain\Entity\Deck\Player;
use App\Domain\Entity\Deck\PlayerCard;
use App\Domain\Repository\DeckRepository;

final class DeckRepositoryMemory implements DeckRepository
{
    private array $decks = [];
    private int $increment = 1;

    public function save(int $capacity, Player $player, array $playerCards): Deck
    {
        $deck = Deck::create([
            'id' => $this->increment,
            'capacity' => $capacity,
            'player' => $player,
            'playerCards' => $playerCards
        ]);

        $this->decks[] = [
            'id' => $this->increment,
            'capacity' => $capacity,
            'player' => [
                'id' => $player->id,
                'name' => $player->name,
                'nickname' => $player->nickname,
                'clan' => $player->clan,
                'trophy' => $player->getTotalTrophy(),
                'cards' => array_map(function (PlayerCard $card) use ($player) {
                    return [
                        'player_id' => $player->id,
                        'card_id' => $card->card->id,
                        'level' => $card->level->value(),
                        'elixir' => $card->elixir->value()
                    ];
                }, $playerCards)
            ],
        ];

        $this->increment++;
        return $deck;
    }

    public function getById(int $deckId):? Deck
    {
        if (empty($this->decks)) {
            return null;
        }

        $deckRecord = array_filter($this->decks, fn ($record) => $record['id'] === $deckId);

        if (!$deckRecord) {
            return null;
        }

        $deckRecord = current($deckRecord);

        return Deck::create([
            'id' => $deckRecord['id'],
            'capacity' => $deckRecord['capacity'],
            'player' => Player::create([
                'id' => $deckRecord['player']['id'],
                'nickname' => $deckRecord['player']['nickname'],
                'name' => $deckRecord['player']['name'],
                'clan' => $deckRecord['player']['clan'],
            ]),
        ]);
    }
}