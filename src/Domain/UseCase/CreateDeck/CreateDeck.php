<?php

namespace App\Domain\UseCase\CreateDeck;

use App\Domain\Exception\DeckCapacityException;
use App\Domain\Exception\DeckCardDuplicateException;
use App\Domain\Repository\DeckRepository;
use App\Domain\Repository\PlayerRepository;

final class CreateDeck
{
    public function __construct(
        private PlayerRepository $playerRepo,
        private DeckRepository $deckRepo
    ) {}

    public function execute(InputData $inputData): OutputData
    {
        $countCards = count($inputData->cardIdList);

        if ($countCards > $inputData->capacity) {
            throw DeckCapacityException::capacityExceeded($inputData->capacity, $countCards);
        }

        $duplicates = array_unique(array_diff_assoc($inputData->cardIdList, array_unique($inputData->cardIdList)));

        if (!empty($duplicates)) {
            throw DeckCardDuplicateException::duplicateCards();
        }

        $player = $this->playerRepo->getById($inputData->playerId);
        $playerCards = $this->playerRepo->getCardsByIdList($inputData->cardIdList);
        $deck = $this->deckRepo->save($inputData->capacity, $player, $playerCards);

        return OutputData::create([
            'id' => $deck->id,
            'capacity' => $deck->capacity,
            'elixirAverage' => $deck->getElixirAverage(),
            'player' => PlayerModel::create([
                'id' => $player->id,
                'name' => $player->name,
                'trophy' => $player->getTotalTrophy()
            ])
        ]);
    }
}