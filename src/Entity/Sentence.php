<?php

namespace App\Entity;

use App\Repository\SentenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SentenceRepository::class)]
class Sentence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $background = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $character_one = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $character_two = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $speaker = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(nullable: true)]
    private ?int $step = null;

    #[ORM\ManyToOne(inversedBy: 'sentences')]
    private ?Acte $acte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): self
    {
        $this->background = $background;

        return $this;
    }

    public function getCharacterOne(): ?string
    {
        return $this->character_one;
    }

    public function setCharacterOne(?string $character_one): self
    {
        $this->character_one = $character_one;

        return $this;
    }

    public function getCharacterTwo(): ?string
    {
        return $this->character_two;
    }

    public function setCharacterTwo(?string $character_two): self
    {
        $this->character_two = $character_two;

        return $this;
    }

    public function getSpeaker(): ?string
    {
        return $this->speaker;
    }

    public function setSpeaker(?string $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStep(): ?int
    {
        return $this->step;
    }

    public function setStep(?int $step): self
    {
        $this->step = $step;

        return $this;
    }

    public function getActe(): ?Acte
    {
        return $this->acte;
    }

    public function setActe(?Acte $acte): self
    {
        $this->acte = $acte;

        return $this;
    }
}
