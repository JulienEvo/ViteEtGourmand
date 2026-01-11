<?php

namespace App\Entity;

use DateTime;

class Horaire
{
    private int $id;
    private int $societeId;
    private string $jour;
    private ?DateTime $ouverture;
    private ?DateTime $fermeture;
    private bool $ferme;

    public function __construct(int $id, int $societeId, string $jour, ?DateTime $ouverture, ?DateTime $fermeture, bool $ferme)
    {
        $this->id = $id;
        $this->societeId = $societeId;
        $this->jour = $jour;
        $this->ouverture = $ouverture;
        $this->fermeture = $fermeture;
        $this->ferme = $ferme;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getSocieteId(): int
    {
        return $this->societeId;
    }
    public function getJour(): string
    {
        return $this->jour;
    }
    public function getOuverture(): ?DateTime
    {
        return $this->ouverture;
    }
    public function getFermeture(): ?DateTime
    {
        return $this->fermeture;
    }
    public function isFerme(): bool
    {
        return $this->ferme;
    }

    public function setOuverture(?DateTime $ouverture): void
    {
        $this->ouverture = $ouverture;
    }
    public function setFermeture(?DateTime $fermeture): void
    {
        $this->fermeture = $fermeture;
    }
    public function setFerme(bool $ferme): void
    {
        $this->ferme = $ferme;
    }
}
