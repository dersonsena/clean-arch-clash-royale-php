<?php

namespace Tests\Integration\Domain\UseCases\CreateDeck;

use App\Adapter\Repository\Memory\DeckRepositoryMemory;
use App\Adapter\Repository\Memory\PlayerMemoryRepository;
use App\Domain\Entity\Deck\Player;
use App\Domain\Exception\InvalidDeckParamException;
use App\Domain\UseCase\CreateDeck\CreateDeck;
use App\Domain\UseCase\CreateDeck\InputData;
use App\Domain\UseCase\DoBattle\DoBattle;
use App\Domain\UseCase\DoBattle\InputData as InputDataSut;
use Tests\TestCase;
use TypeError;

final class DoBattleTest extends TestCase
{
    public static function makeCreateDeck(): CreateDeck
    {
        $playerRepo = new PlayerMemoryRepository();
        $deckRepo = new DeckRepositoryMemory();
        return new CreateDeck($playerRepo, $deckRepo);
    }

    public static function makeSut(): DoBattle
    {
        $deckRepository = new DeckRepositoryMemory();
        return new DoBattle($deckRepository);
    }

    public function testIfAnExceptionIsThrownWhenJustOneDeckIsProvided()
    {
        $this->expectException(TypeError::class);

        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $this->faker->numberBetween(1, 3),
            'cardIdList' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);

        $result = self::makeCreateDeck()->execute($input);

        $inputData = InputDataSut::create([
            'deckId1' => $result->id,
            'deckId2' => null
        ]);

        self::makeSut()->execute($inputData);
    }

    public function testIfExceptionIsThrownWhenPlayersIsTheSame()
    {
        $this->expectException(InvalidDeckParamException::class);

        $playerId = $this->faker->numberBetween(1, 3);

        $inputPlayer1 = InputData::create([
            'capacity' => 8,
            'playerId' => $playerId,
            'cardIdList' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);

        $inputPlayer2 = InputData::create([
            'capacity' => 8,
            'playerId' => $playerId,
            'cardIdList' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);

        $resultPlayer1 = self::makeCreateDeck()->execute($inputPlayer1);
        $resultPlayer2 = self::makeCreateDeck()->execute($inputPlayer2);

        $inputData = InputDataSut::create([
            'deckId1' => $resultPlayer1->id,
            'deckId2' => $resultPlayer2->id
        ]);

        self::makeSut()->execute($inputData);
    }

    public function testIfBattleReturnsTheCorrectResult()
    {
        $inputPlayer1 = InputData::create([
            'capacity' => 8,
            'playerId' => 1,
            'cardIdList' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);

        $inputPlayer2 = InputData::create([
            'capacity' => 8,
            'playerId' => 2,
            'cardIdList' => [1, 2, 3, 4, 8]
        ]);

        $resultPlayer1 = self::makeCreateDeck()->execute($inputPlayer1);
        $resultPlayer2 = self::makeCreateDeck()->execute($inputPlayer2);

        $inputData = InputDataSut::create([
            'deckId1' => $resultPlayer1->id,
            'deckId2' => $resultPlayer2->id
        ]);

        $result = self::makeSut()->execute($inputData);

        $this->assertSame($result->winnerTrophy, Player::POINTS_PER_VICTORY);
        $this->assertSame($result->loserTrophy, Player::POINTS_PER_DEFEAT);
    }
}