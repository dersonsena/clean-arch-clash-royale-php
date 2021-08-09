<?php

namespace App\Domain\UseCase\CreateDeck;

use stdClass;

final class OutputData
{
    public string|int $id;
    public stdClass $player;
    public float $elixirAverage;

    private function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->player = $values['player'];
        $this->elixirAverage = $values['elixirAverage'];
    }

    public static function create(array $data): OutputData
    {
        $data['player'] = (object)$data['player'];
        return new OutputData($data);
    }
}