<?php

namespace App\Domain\UseCase\CreateDeck;

use stdClass;

final class InputData
{
    public int $capacity;
    public stdClass $player;
    public array $cards = [];

    private function __construct(array $values)
    {
        $this->capacity = $values['capacity'];
        $this->player = $values['player'];
        $this->cards = $values['cards'];
    }

    public static function create(array $data): InputData
    {
        $data['player'] = (object)$data['player'];
        $data['cards'] = array_map(fn ($card) => (object)$card, $data['cards']);

        return new InputData($data);
    }
}