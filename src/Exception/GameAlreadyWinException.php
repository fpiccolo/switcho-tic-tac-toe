<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class GameAlreadyWinException extends \Exception
{
    public function __construct(int $player)
    {
        parent::__construct("Game already win by player [{$player}]", Response::HTTP_BAD_REQUEST);
    }
}