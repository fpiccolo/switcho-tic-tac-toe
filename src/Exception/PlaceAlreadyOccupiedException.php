<?php
declare(strict_types=1);

namespace App\Exception;


use Symfony\Component\HttpFoundation\Response;

class PlaceAlreadyOccupiedException extends \Exception
{
    public function __construct(int $place)
    {
        parent::__construct("Place [{$place}] already occupied", Response::HTTP_BAD_REQUEST);
    }
}