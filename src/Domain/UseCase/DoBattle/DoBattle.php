<?php

declare(strict_types=1);

namespace App\Domain\UseCase\DoBattle;

use App\Domain\Entity\Deck\Deck;
use App\Domain\Entity\Deck\PlayerEvent;
use App\Domain\Exception\InvalidDeckParamException;
use App\Domain\Repository\DeckRepository;

final class DoBattle
{
    public const JUSTICE_METRIC = 100;

    public function __construct(
        private DeckRepository $deckRepo
    ){}

    public function execute(InputData $inputData): OutputData
    {
        $deck1 = $this->deckRepo->getById($inputData->deckId1);
        $deck2 = $this->deckRepo->getById($inputData->deckId2);

        if ($deck1->player->id === $deck2->player->id) {
            throw InvalidDeckParamException::samePlayer();
        }

        if ($deck1->player->getTotalTrophy() - $deck2->player->getTotalTrophy() > self::JUSTICE_METRIC) {
            throw InvalidDeckParamException::unfairBattle();
        }

        /** @var Deck[] $decks */
        $decks = [$deck1, $deck2];
        $winnerDeck = $decks[0];
        $loserDeck = $decks[1];

        // Event sourcing here!
        $winnerDeck->player->addEvent(new PlayerEvent(PlayerEvent::BATTLE_WON));
        $loserDeck->player->addEvent(new PlayerEvent(PlayerEvent::BATTLE_LOST));

        return OutputData::create([
            'winnerName' => $winnerDeck->player->name,
            'winnerTrophy' => $winnerDeck->player->getTotalTrophy(),
            'loserName' => $loserDeck->player->name,
            'loserTrophy' => $loserDeck->player->getTotalTrophy()
        ]);
    }
}