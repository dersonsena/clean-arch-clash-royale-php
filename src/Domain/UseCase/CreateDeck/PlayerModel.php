<?php

declare(strict_types=1);

namespace App\Domain\UseCase\CreateDeck;

use RuntimeException;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read int $trophy
 */
final class PlayerModel
{
    private int $id;
    private string $name;
    private int $trophy;

    private function __construct(array $values)
    {
        $this->id = $values['id'];
        $this->name = $values['name'];
        $this->trophy = $values['trophy'];
    }

    public static function create(array $data): self
    {
        $data['id'] = (int)$data['id'];
        $data['trophy'] = (int)$data['trophy'];
        return new PlayerModel($data);
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name)) {
            throw new RuntimeException(sprintf("Invalid PlayerModel Property '%s'", $name));
        }

        return $this->{$name};
    }
}