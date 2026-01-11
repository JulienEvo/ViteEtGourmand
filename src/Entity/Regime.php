<?php

namespace App\Entity;

class Regime
{
    private int $id;
    private string $libelle;
    private string $description;

    public function __construct() {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getLibelle(): string
    {
        return $this->libelle;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
