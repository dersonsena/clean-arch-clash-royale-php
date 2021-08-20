<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

use App\Domain\Exception\InvalidPlayerException;
use RuntimeException;

/**
 * @property-read string|int|null $id
 * @property-read string $nickname
 * @property-read string $name
 * @property-read string $clan
 */
final class Player
{
    public const POINTS_PER_VICTORY = 50;
    public const POINTS_PER_DEFEAT = 5;

    private string|int|null $id;
    private string $nickname;
    private string $name;
    private string $clan;
    private array $events;

    private function __construct(array $values)
    {
        $this->id = $values['id'] ?? null;
        $this->nickname = $values['nickname'];
        $this->name = $values['name'];
        $this->clan = $values['clan'];
        $this->events = [];
    }

    public static function create(array $values): Player
    {
        $regex = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";

        if (preg_match($regex, $values['nickname'])) {
            throw InvalidPlayerException::forInvalidNickname($values['nickname']);
        }

        return new Player($values);
    }

    public function getTotalTrophy(): int
    {
        $total = 0;

        if (empty($this->events)) {
            return $total;
        }

        foreach ($this->events as $event) {
            if ($event === PlayerEvent::BATTLE_WON) {
                $total += self::POINTS_PER_VICTORY;
                continue;
            }

            if ($event === PlayerEvent::BATTLE_LOST) {
                $total -= self::POINTS_PER_DEFEAT;
            }
        }

        return $total >= 0 ? $total : 0;
    }

    public function addEvent(PlayerEvent $event)
    {
        $this->events[] = $event;
    }

    public function __get(string $name)
    {
        if (!property_exists($this, $name) || $name === 'events') {
            throw new RuntimeException(sprintf("Invalid Player Property '%s'", $name));
        }

        return $this->{$name};
    }
}