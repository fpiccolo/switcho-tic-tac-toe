<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'game', targetEntity: GameMove::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => "DESC"])]
    private Collection $gameMoves;

    #[ORM\Column(nullable: true)]
    private ?int $winningPlayer = null;

    #[ORM\Column]
    private bool $completed = false;

    public function __construct()
    {
        $this->moves = new ArrayCollection();
        $this->gameMoves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection<int, GameMove>
     */
    public function getGameMoves(): Collection
    {
        return $this->gameMoves;
    }

    public function addGameMove(GameMove $gameMove): self
    {
        if (!$this->gameMoves->contains($gameMove)) {
            $this->gameMoves->add($gameMove);
            $gameMove->setGame($this);
        }

        return $this;
    }

    public function removeGameMove(GameMove $gameMove): self
    {
        if ($this->gameMoves->removeElement($gameMove)) {
            // set the owning side to null (unless already changed)
            if ($gameMove->getGame() === $this) {
                $gameMove->setGame(null);
            }
        }

        return $this;
    }

    public function getLastMove(): ?GameMove
    {
        if(0 === $this->gameMoves->count()){
            return null;
        }

        return $this->gameMoves->first();
    }

    /**
     * @return array<int>
     */
    public function getPlacesOccupied(): array
    {
        return array_map(function (GameMove $gameMove){
            return $gameMove->getPlace();
        }, $this->gameMoves->toArray());
    }

    public function getMovesPlacesOfAPlayer(int $player)
    {
        $movesOfAPlayer = array_filter($this->gameMoves->toArray(), function (GameMove $gameMove) use ($player){
            return $player === $gameMove->getPlayer();
        });

        return array_map(function(GameMove $gameMove): int {
            return $gameMove->getPlace();
        }, $movesOfAPlayer);

    }

    public function getWinningPlayer(): ?int
    {
        return $this->winningPlayer;
    }

    public function setWinningPlayer(int $winningPlayer): self
    {
        $this->winningPlayer = $winningPlayer;

        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }
}
