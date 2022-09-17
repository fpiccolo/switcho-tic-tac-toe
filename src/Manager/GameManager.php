<?php
declare(strict_types=1);

namespace App\Manager;

use App\DTO\Input\MoveInput;
use App\DTO\Output\GameOutput;
use App\Exception\GameAlreadyCompletedWithoutWinnerException;
use App\Exception\GameAlreadyWinException;
use App\Exception\GameNotFoundException;
use App\Entity\Game;
use App\Entity\GameMove;
use App\Exception\InvalidPlaceException;
use App\Exception\InvalidPlayerException;
use App\Exception\NotValidPlayerTurnException;
use App\Exception\PlaceAlreadyOccupiedException;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;

class GameManager
{
    private const VALID_PLACES = [
        1, 2, 3, 4, 5, 6, 7, 8, 9
    ];

    private const VALID_PLAYERS = [
        1, 2
    ];

    private const WIN_PLACES = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9],
        [1, 4, 7],
        [2, 5, 8],
        [3, 6, 9],
        [1, 5, 9],
        [3, 5, 7],
    ];

    private EntityManagerInterface $entityManager;
    private GameRepository $gameRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        GameRepository         $gameRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->gameRepository = $gameRepository;
    }

    public function createNewGame(): GameOutput
    {

        $game = new Game();

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return new GameOutput($game);
    }

    public function move(MoveInput $dtoInput): GameOutput
    {

        $game = $this->getGame($dtoInput->gameId);

        $this->moveValidation($game, $dtoInput);

        $gameMove = (new GameMove())
            ->setPlayer($dtoInput->player)
            ->setPlace($dtoInput->place);

        $game->addGameMove($gameMove);

        if ($this->checkIfPlayerWin($game->getMovesPlacesOfAPlayer($dtoInput->player))) {
            $game->setWinningPlayer($dtoInput->player);
            $game->setCompleted(true);
        }

        if($game->getGameMoves()->count() === 9){
            $game->setCompleted(true);
        }

        $this->entityManager->persist($game);
        $this->entityManager->flush();

        return new GameOutput($game);
    }

    private function getGame(int $gameId): Game
    {
        $game = $this->gameRepository->find($gameId);

        if (null === $game) {
            throw new GameNotFoundException($gameId);
        }

        return $game;
    }

    private function moveValidation(Game $game, MoveInput $dtoInput)
    {
        $this->checkIfGameIsAlreadyCompleted($game);

        $this->validatePlaceOfTheMove($game, $dtoInput->place);

        $this->validatePlayerTurn($game, $dtoInput->player);
    }

    private function checkIfGameIsAlreadyCompleted(Game $game): void
    {
        if (null !== $game->getWinningPlayer()) {
            throw new GameAlreadyWinException($game->getWinningPlayer());
        }

        if (true === $game->isCompleted()) {
            throw new GameAlreadyCompletedWithoutWinnerException();
        }
    }

    private function validatePlaceOfTheMove(Game $game, int $place): void
    {
        if (!in_array($place, self::VALID_PLACES)) {
            throw new InvalidPlaceException($place);
        }

        if (in_array($place, $game->getPlacesOccupied())) {
            throw new PlaceAlreadyOccupiedException($place);
        }
    }

    private function validatePlayerTurn(Game $game, int $player): void
    {

        if(!in_array($player, self::VALID_PLAYERS)){
            throw new InvalidPlayerException($player);
        }

        $lastGameMove = $game->getLastMove();

        if (null !== $lastGameMove && $player === $lastGameMove->getPlayer()) {
            throw new NotValidPlayerTurnException($player);
        }
    }

    private function checkIfPlayerWin(array $movePositions): bool
    {
        foreach (self::WIN_PLACES as $winPosition) {
            if (count(array_intersect($movePositions, $winPosition)) == count($winPosition)) {
                return true;
            }
        }

        return false;
    }
}