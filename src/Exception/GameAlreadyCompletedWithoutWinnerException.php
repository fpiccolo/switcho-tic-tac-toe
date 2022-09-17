<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class GameAlreadyCompletedWithoutWinnerException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Game already completed without winner", Response::HTTP_BAD_REQUEST);
    }
}