<?php

namespace App\Domain\UseCase\CreateDeck;

use App\Domain\Entity\Deck\Card;
use App\Domain\Entity\Deck\Player;
use App\Domain\Exception\DeckCapacityException;
use App\Domain\Exception\DeckCardDuplicateException;

final class CreateDeck
{
    public function execute(InputData $inputData)
    {
        $player = Player::create((array)$inputData->player);
        $countCards = count($inputData->cards);

        if ($countCards > $inputData->capacity) {
            throw DeckCapacityException::capacityExceeded($inputData->capacity, $countCards);
        }

        $names = array_map(fn ($card) => strtolower($card->name), $inputData->cards);

        if (count(array_unique($names)) < count($names)) {
            throw DeckCardDuplicateException::duplicateCards();
        }

        foreach ($inputData->cards as $card) {
            Card::create([
                'name' => $card->name,
                'level' => $card->level,
                'elixir' => $card->elixir
            ]);
        }
    }
}