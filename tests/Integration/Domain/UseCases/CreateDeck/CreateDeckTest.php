<?php

namespace Tests\Integration\Domain\UseCases\CreateDeck;

use App\Adapter\Repository\Memory\CardMemoryRepository;
use App\Adapter\Repository\Memory\DeckRepositoryMemory;
use App\Adapter\Repository\Memory\PlayerMemoryRepository;
use App\Domain\Exception\DeckCapacityException;
use App\Domain\Exception\DeckCardDuplicateException;
use App\Domain\Exception\InvalidCardException;
use App\Domain\Exception\InvalidPlayerException;
use App\Domain\UseCase\CreateDeck\CreateDeck;
use App\Domain\UseCase\CreateDeck\InputData;
use Tests\TestCase;

class CreateDeckTest extends TestCase
{
    public static function makeSut(): CreateDeck
    {
        $playerRepo = new PlayerMemoryRepository();
        $deckRepo = new DeckRepositoryMemory();
        return new CreateDeck($playerRepo, $deckRepo);
    }
    
    public function testIfExceptionIsThrownWhenDeckCapacityHasBeenReached()
    {
        $this->expectException(DeckCapacityException::class);

        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $this->faker->randomNumber(),
            'cardIdList' => [
                // 12 cards
                $this->faker->randomNumber(), $this->faker->randomNumber(), $this->faker->randomNumber(),
                $this->faker->randomNumber(), $this->faker->randomNumber(), $this->faker->randomNumber(),
                $this->faker->randomNumber(), $this->faker->randomNumber(), $this->faker->randomNumber(),
                $this->faker->randomNumber(), $this->faker->randomNumber(), $this->faker->randomNumber()
            ]
        ]);

        self::makeSut()->execute($input);
    }

    public function testIfExceptionIsThrowWhenThereAreDuplicateCards()
    {
        $this->expectException(DeckCardDuplicateException::class);

        $duplicateCardId = $this->faker->randomDigit();

        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $this->faker->randomNumber(),
            'cardIdList' => [
                $duplicateCardId, $this->faker->randomNumber(), $this->faker->randomNumber(),
                $this->faker->randomNumber(), $duplicateCardId, $this->faker->randomNumber(),
                $this->faker->randomNumber(), $this->faker->randomNumber()
            ]
        ]);

        self::makeSut()->execute($input);
    }

    public function testIfExceptionIsThrownWhenPlayerDoesNotExists()
    {
        $this->expectException(InvalidPlayerException::class);
        $invalidPlayerId = $this->faker->numberBetween(10000);

        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $invalidPlayerId,
            'cardIdList' => [
                $this->faker->numberBetween(), $this->faker->numberBetween(), $this->faker->numberBetween(),
                $this->faker->numberBetween(), $this->faker->numberBetween(), $this->faker->numberBetween(),
                $this->faker->numberBetween(), $this->faker->numberBetween()
            ]
        ]);

        self::makeSut()->execute($input);
    }

    public function testIfExceptionIsThrownWhenAtLeastOneCardDoesNotExists()
    {
        $this->expectException(InvalidCardException::class);
        $invalidCardId = $this->faker->numberBetween(10000);

        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $this->faker->numberBetween(1, 3),
            'cardIdList' => [
                $this->faker->numberBetween(), $this->faker->numberBetween(), $this->faker->numberBetween(),
                $this->faker->numberBetween(), $this->faker->numberBetween(), $this->faker->numberBetween(),
                $invalidCardId, $this->faker->numberBetween()
            ]
        ]);

        self::makeSut()->execute($input);
    }

    public function testIfDeckIsCreatedCorrectly()
    {
        $input = InputData::create([
            'capacity' => 8,
            'playerId' => $this->faker->numberBetween(1, 3),
            'cardIdList' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);

        $result = self::makeSut()->execute($input);

        $this->assertNotNull($result->id);
        $this->assertSame($result->player->id, $input->playerId);
    }
}