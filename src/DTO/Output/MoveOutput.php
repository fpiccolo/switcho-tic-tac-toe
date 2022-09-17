<?php
declare(strict_types=1);

namespace App\DTO\Output;

use App\Entity\GameMove;

class MoveOutput
{
    public int $player;

    public int $position;

    public function __construct(GameMove $gameMove)
    {
        $this->player = $gameMove->getPlayer();
        $this->position = $gameMove->getPlace();
    }
}