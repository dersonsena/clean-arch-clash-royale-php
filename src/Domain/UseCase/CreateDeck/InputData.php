<?php

namespace App\Domain\UseCase\CreateDeck;

use RuntimeException;

/**
 * @property-read array $cardIdList
 * @property-read int $playerId
 * @property-read int $capacity
 */
final class InputData
{
    /**
     * @var int[]
     */
    private array $cardIdList = [];
    private int $playerId;
    private int $capacity;

    private function __construct(array $values)
    {
        $this->cardIdList = $values['cardIdList'];
        $this->playerId = $values['playerId'];
        $this->capacity = $values['capacity'];
    }

    public static function create(array $data): InputData
    {
        $data['playerId'] = (int)$data['playerId'];
        $data['cardIdList'] = array_map(fn ($cardId) => (int)$cardId, $data['cardIdList']);
        return new InputData($data);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid Create Deck Input Data Property '%s'", $name));
        }

        return $this->{$name};
    }
}