<?php

namespace App\Entity;

use DateTime;
class Avis
{
    private int $id;
    private int $utilisateurId;
    private int $note;
    private string $commentaire;
    private ?bool $valide;
    private DateTime $createdAt;

    public function __construct(int $id, int $utilisateurId, int $note, string $commentaire, ?bool $valide, DateTime $createdAt)
    {
        $this->id = $id;
        $this->utilisateurId = $utilisateurId;
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->valide = $valide;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUtilisateurId(): int
    {
        return $this->utilisateurId;
    }
    public function getNote(): int
    {
        return $this->note;
    }
    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function getValide(): ?bool
    {
        return $this->valide;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setNote(int $note): void
    {
        $this->note = $note;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
    }
    public function setValide(?bool $valide): void
    {
        $this->valide = $valide;
    }
}
