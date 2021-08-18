<?php

declare(strict_types=1);

namespace App\Adapter\Repository\Memory;

use App\Domain\Entity\Deck\Card;
use App\Domain\Entity\Deck\Player;
use App\Domain\Entity\Deck\PlayerCard;
use App\Domain\Exception\InvalidCardException;
use App\Domain\Exception\InvalidPlayerException;
use App\Domain\Repository\PlayerRepository;

final class PlayerMemoryRepository implements PlayerRepository
{
    private array $players = [
        ['id' => 1, 'name' => 'Kilderson Sena', 'nickname' => 'dersonsena', 'clan' => 'Nodestinus'],
        ['id' => 2, 'name' => 'Dayanny Maria', 'nickname' => 'dadamaria', 'clan' => 'Nodestinus'],
        ['id' => 3, 'name' => 'Kauan Lucas', 'nickname' => 'kalu', 'clan' => 'Nodestinus']
    ];

    private array $cards = [
        ['id' => 1, 'card_id' => 3, 'official_name' => 'Ice Spirit', 'level' => 12, 'elixir' => 1],
        ['id' => 2, 'card_id' => 2, 'official_name' => 'Tesla', 'level' => 11, 'elixir' => 4],
        ['id' => 3, 'card_id' => 1, 'official_name' => 'Wizard', 'level' => 11, 'elixir' => 5],
        ['id' => 4, 'card_id' => 6, 'official_name' => 'Valkyrie', 'level' => 9, 'elixir' => 4],
        ['id' => 5, 'card_id' => 7, 'official_name' => 'Arrows', 'level' => 5, 'elixir' => 3],
        ['id' => 6, 'card_id' => 9, 'official_name' => 'Globins', 'level' => 10, 'elixir' => 2],
        ['id' => 7, 'card_id' => 10, 'official_name' => 'Balloon', 'level' => 12, 'elixir' => 5],
        ['id' => 8, 'card_id' => 8, 'official_name' => 'Guards', 'level' => 13, 'elixir' => 3],
        ['id' => 9, 'card_id' => 5, 'official_name' => 'Fireball', 'level' => 9, 'elixir' => 4],
        ['id' => 10, 'card_id' => 13, 'official_name' => 'Fisherman', 'level' => 8, 'elixir' => 3],
        ['id' => 11, 'card_id' => 11, 'official_name' => 'Zap', 'level' => 12, 'elixir' => 2],
        ['id' => 12, 'card_id' => 4, 'official_name' => 'Baby Dragon', 'level' => 10, 'elixir' => 4],
        ['id' => 13, 'card_id' => 12, 'official_name' => 'Bats', 'level' => 11, 'elixir' => 2]
    ];

    public function getById(int $playerId): Player
    {
        $playerRecord = current(array_filter($this->players, fn ($record) => $record['id'] === $playerId));

        if (!$playerRecord) {
            throw InvalidPlayerException::notFound($playerId);
        }

        return Player::create([
            'id' => $playerRecord['id'],
            'nickname' => $playerRecord['nickname'],
            'name' => $playerRecord['name'],
            'clan' => $playerRecord['clan'],
        ]);
    }

    public function getCardsByIdList(array $cardIdList): array
    {
        $collection = [];

        foreach ($cardIdList as $cardId) {
            $cardFound = current(array_filter($this->cards, fn ($cardRecord) => $cardRecord['card_id'] === $cardId));

            if (!$cardFound) {
                throw InvalidCardException::notFound($cardId);
            }

            $collection[] = PlayerCard::create([
                'card' => Card::create([
                    'id' => $cardFound['card_id'],
                    'name' => $cardFound['official_name']
                ]),
                'level' => $cardFound['level'],
                'elixir' => $cardFound['elixir']
            ]);
        }

        return $collection;
    }
}