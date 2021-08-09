<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entities\Deck\Player;

interface PlayerRepository
{
    public function createPlayerIfNotExists(Player $player): Player;
}