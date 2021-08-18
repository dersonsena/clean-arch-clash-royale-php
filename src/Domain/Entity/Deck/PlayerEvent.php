<?php

declare(strict_types=1);

namespace App\Domain\Entity\Deck;

final class PlayerEvent
{
    public const BATTLE_WON = 'battle-won';
    public const BATTLE_LOST = 'battle-lost';

    private string $type;
    private array $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}