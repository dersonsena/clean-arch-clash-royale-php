<?php

namespace Tests\Integration\Domain\UseCases\CreateDeck;

use App\Domain\Exception\DeckCapacityException;
use App\Domain\Exception\DeckCardDuplicateException;
use App\Domain\Exception\InvalidCardException;
use App\Domain\Exception\InvalidPlayerException;
use App\Domain\UseCase\CreateDeck\CreateDeck;
use App\Domain\UseCase\CreateDeck\InputData;
use Tests\TestCase;

class CreateDeckTest extends TestCase
{
    public function testIfExceptionIsThrownWhenPlayerNicknameIsInvalid()
    {
        $this->expectException(InvalidPlayerException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => 'dada#{}/\[]$%&&',
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => 'Fisherman', 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrownWhenDeckCapacityHasBeenReached()
    {
        $this->expectException(DeckCapacityException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrowWhenThereAreDuplicateCards()
    {
        $this->expectException(DeckCardDuplicateException::class);

        $duplicateName = $this->faker->name();

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => strtoupper($duplicateName), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => ucfirst($duplicateName), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrownWhenCardLevelIsGreaterThanLimit()
    {
        $this->expectException(InvalidCardException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 40, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrownWhenCardLevelIsLessThanLimit()
    {
        $this->expectException(InvalidCardException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => -2, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrownWhenCardElixirIsGreaterThanLimit()
    {
        $this->expectException(InvalidCardException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 20],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }

    public function testIfExceptionIsThrownWhenCardElixirIsLessThanLimit()
    {
        $this->expectException(InvalidCardException::class);

        $input = InputData::create([
            'capacity' => 8,
            'player' => [
                'name' => $this->faker->name(),
                'nickname' => $this->faker->userName,
                'clan' => $this->faker->name()
            ],
            'cards' => [
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => -2],
                ['name' => $this->faker->name(), 'level' => 6, 'elixir' => 3]
            ]
        ]);

        $sut = new CreateDeck();
        $sut->execute($input);
    }
}