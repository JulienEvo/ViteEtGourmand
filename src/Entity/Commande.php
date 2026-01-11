<?php

namespace App\Entity;

use DateTime;

class Commande
{
    private int $id;
    private int $utilisateurId;
    private int $etatId;
    private ?string $numero;
    private ?DateTime $date;
    private ?DateTime $reduction;

    public function __construct(int $id, int $utilisateurId, int $etatId, ?string $numero, ?DateTime $date, ?DateTime $reduction)
    {
        $this->id = $id;
        $this->utilisateurId = $utilisateurId;
        $this->etatId = $etatId;
        $this->numero = $numero;
        $this->date = $date;
        $this->reduction = $reduction;
    }

    public function getId(): int
    { return $this->id; }
    public function getUtilisateurId(): int
    {
        return $this->utilisateurId;
    }
    public function getEtatId(): int
    {
        return $this->etatId;
    }
    public function getNumero(): ?string
    {
        return $this->numero;
    }
    public function getDate(): ?DateTime
    {
        return $this->date;
    }
    public function getReduction(): ?DateTime
    {
        return $this->reduction;
    }

    public function setEtatId(int $etatId): void
    {
        $this->etatId = $etatId;
    }
    public function setNumero(?string $numero): void
    {
        $this->numero = $numero;
    }
    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }
    public function setReduction(?DateTime $reduction): void
    {
        $this->reduction = $reduction;
    }
}
