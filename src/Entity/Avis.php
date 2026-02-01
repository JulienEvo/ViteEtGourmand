<?php

namespace App\Entity;

use DateTime;
class Avis
{
    private int $id;
    private int $utilisateur_id;
    private int $commande_id;
    private int $note;
    private string $commentaire;
    private ?bool $valide;
    private DateTime $created_at;

    public function __construct(
        int $id = 0,
        int $utilisateur_id = 0,
        int $commande_id = 0,
        int $note = 5,
        string $commentaire = '',
        ?bool $valide = null,
        DateTime $created_at = new DateTime
    )
    {
        $this->setId($id);
        $this->setUtilisateur_id($utilisateur_id);
        $this->setCommande_id($commande_id);
        $this->setNote($note);
        $this->setCommentaire($commentaire);
        $this->setValide($valide);
        $this->setCreatedAt($created_at);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUtilisateur_id(): int
    {
        return $this->utilisateur_id;
    }
    public function getCommande_id(): int
    {
        return $this->commande_id;
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
    public function getCreated_at(): DateTime
    {
        return $this->created_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setUtilisateur_id(int $utilisateur_id): void
    {
        $this->utilisateur_id = $utilisateur_id;
    }
    public function setCommande_id(int $commande_id): void
    {
        $this->commande_id = $commande_id;
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
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
