<?php
declare(strict_types=1);

namespace App\DTO\Input;

class MoveInput
{
    public int $gameId;
    public int $player;
    public int $place;

    public function __construct(
        int $gameId,
        int $player,
        int $place
    )
    {
        $this->gameId = $gameId;
        $this->player = $player;
        $this->place = $place;
    }
}