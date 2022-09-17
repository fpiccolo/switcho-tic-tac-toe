<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class InvalidPlayerException extends \Exception
{
    public function __construct(int $player)
    {
        parent::__construct("Player [{$player}] is not a valid player", Response::HTTP_BAD_REQUEST);
    }
}