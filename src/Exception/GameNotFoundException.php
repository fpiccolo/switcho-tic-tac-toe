<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class GameNotFoundException extends \Exception
{
    public function __construct(int $gameId)
    {
        parent::__construct("Game not found with ID [{$gameId}]", Response::HTTP_NOT_FOUND);
    }
}