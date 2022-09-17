<?php
declare(strict_types=1);

namespace App\Controller;

use App\DTO\Input\MoveInput;
use App\DTO\Output\ExceptionOutput;
use App\Manager\GameManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    private GameManager $gameManager;

    public function __construct(
        GameManager $gameManager
    )
    {
        $this->gameManager = $gameManager;
    }

    #[Route('game', name: 'game_creation', methods: ['POST'])]
    public function createNewMatchAction(): Response
    {
        return $this->json(
            $this->gameManager->createNewGame()
        );
    }

    #[Route('game/{gameId}/move', name: 'game_move' ,methods: ['POST'])]
    public function moveAction(Request $request, int $gameId): Response
    {
        $body = json_decode($request->getContent(),true);

        $dtoInput = new MoveInput($gameId, $body['player'], $body['place']);

        try {
            $dto = $this->gameManager->move($dtoInput);
        }catch (\Exception $exception){
            return $this->json(
                new ExceptionOutput($exception->getMessage(), $exception->getCode()),
                $exception->getCode()
            );
        }

        return $this->json(
            $dto
        );
    }
}