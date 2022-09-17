<?php
declare(strict_types=1);

namespace App\DTO\Output;

use App\Entity\Game;

class GameOutput
{
    public int $id;

    public ?int $winningPlayer;

    public bool $completed;

    /** @var MoveOutput[] */
    public array $moves = [];

    public function __construct(Game $game)
    {
        $this->id = $game->getId();
        $this->winningPlayer = $game->getWinningPlayer();
        $this->completed = $game->isCompleted();
        foreach ($game->getGameMoves() as $gameMove){
            $this->moves[] = new MoveOutput($gameMove);
        }
    }
}