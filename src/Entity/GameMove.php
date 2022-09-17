<?php

namespace App\Entity;

use App\Repository\GameMoveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameMoveRepository::class)]
class GameMove
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $player;

    #[ORM\Column]
    private int $place;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'gameMoves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): int
    {
        return $this->player;
    }

    public function setPlayer(int $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getPlace(): int
    {
        return $this->place;
    }

    public function setPlace(int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }

}
