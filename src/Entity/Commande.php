<?php

namespace App\Entity;

use DateTime;

class Commande
{
    private int $id;
    private int $utilisateur_id;
    private int $menu_id;
    private int $commande_etat_id;
    private ?string $numero;
    private ?DateTime $date;
    private ?float $montant_ht;
    private ?float $remise;
    private ?DateTime $created_at;

    public function __construct(
        int $id = 0,
        int $utilisateur_id = 0,
        int $menu_id = 0,
        int $commande_etat_id = 1,
        ?string $numero = null,
        ?DateTime $date = null,
        ?float $montant_ht = null,
        ?float $remise = null,
        ?DateTime $created_at = new DateTime(),
    )
    {
        $this->id = $id;
        $this->utilisateur_id = $utilisateur_id;
        $this->menu_id = $menu_id;
        $this->commande_etat_id = $commande_etat_id;
        $this->numero = $numero;
        $this->date = $date;
        $this->montant_ht = $montant_ht;
        $this->remise = $remise;
        $this->created_at = $created_at;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUtilisateur_id(): int
    {
        return $this->utilisateur_id;
    }
    public function getMenu_id(): int
    {
        return $this->menu_id;
    }
    public function getCommande_etat_id(): int
    {
        return $this->commande_etat_id;
    }
    public function getNumero(): ?string
    {
        return $this->numero;
    }
    public function getDate(): ?DateTime
    {
        return $this->date;
    }
    public function getRemise(): ?float
    {
        return $this->remise;
    }
    public function getMontant_ht(): ?float
    {
        return $this->montant_ht;
    }
    public function getCreated_at(): ?DateTime
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
    public function setMenu_id(int $menu_id): void
    {
        $this->menu_id = $menu_id;
    }
    public function setCommande_etat_id(int $commande_etat_id): void
    {
        $this->commande_etat_id = $commande_etat_id;
    }
    public function setNumero(?string $numero): void
    {
        $this->numero = $numero;
    }
    public function setDate(?DateTime $date): void
    {
        $this->date = $date;
    }
    public function setRemise(?float $remise): void
    {
        $this->remise = $remise;
    }
    public function setMontant_ht(?float $montant_ht): void
    {
        $this->montant_ht = $montant_ht;
    }
    public function setCreated_at(?DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}
