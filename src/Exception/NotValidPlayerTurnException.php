<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class NotValidPlayerTurnException extends \Exception
{
    public function __construct(int $player)
    {
        parent::__construct("Not valid turn for player [{$player}]", Response::HTTP_BAD_REQUEST);
    }
}