<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use App\Domain\Exception\InvalidPlayerException;

final class Player
{
    public string|int|null $id;
    public string $nickname;
    public string $name;
    public string $clan;

    private function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->nickname = $values['nickname'];
        $this->name = $values['name'];
        $this->clan = $values['clan'];
    }

    public static function create(array $values): Player
    {
        $regex = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";

        if (preg_match($regex, $values['nickname'])) {
            throw InvalidPlayerException::forInvalidNickname($values['nickname']);
        }

        return new Player($values);
    }
}