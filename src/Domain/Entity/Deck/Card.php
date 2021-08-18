<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

final class Card
{
    public string|int|null $id;
    public string $name;

    public function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->name = $values['name'];
    }

    public static function create(array $values): self
    {
        return new Card($values);
    }
}