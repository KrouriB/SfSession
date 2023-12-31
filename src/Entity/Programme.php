<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nombreJours = null;

    #[ORM\ManyToOne(inversedBy: 'programmes', cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Session $session = null;

    #[ORM\ManyToOne(inversedBy: 'programmes', cascade:["persist"])]
    private ?Module $module = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): static
    {
        $this->module = $module;

        return $this;
    }

    public function __ToString(): string
    {
        return $this->module . " - " . $this->module->getCategorie();
    }
}
