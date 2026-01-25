<?php

namespace App\Entity;

use DateTime;

class Horaire
{
    private int $id;
    private int $societe_id;
    private string $jour;
    private ?DateTime $ouverture;
    private ?DateTime $fermeture;
    private bool $ferme;

    public function __construct(int $id, int $societe_id, string $jour, ?DateTime $ouverture, ?DateTime $fermeture, bool $ferme)
    {
        $this->setId($id);
        $this->setSociete_id($societe_id);
        $this->setJour($jour);
        $this->setOuverture($ouverture);
        $this->setFermeture($fermeture);
        $this->setFerme($ferme);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getSociete_id(): int
    {
        return $this->societe_id;
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

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setSociete_id(int $societe_id): void
    {
        $this->societe_id = $societe_id;
    }
    public function setJour(string $jour): void
    {
        $this->jour = $jour;
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
