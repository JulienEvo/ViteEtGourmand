<?php

namespace App\Entity;

use DateTime;

class Commande
{
const ETAT_EN_PREPARATION = 1;
const ETAT_ACCEPTEE = 2;
const ETAT_REFUSEE = 3;
const ETAT_ANNULEE = 4;
const ETAT_SUPPRIMEE = 5;
const ETAT_EN_COURS_LIVRAISON = 6;
const ETAT_LIVREE = 7;
const ETAT_EN_ATTENTE_MATERIEL = 8;
const ETAT_TERMINEE = 9;


private int $id;
private int $utilisateur_id;
private int $menu_id;
private int $commande_etat_id;
private ?string $numero;
private ?DateTime $date;
private ?string $adresse_livraison;
private ?string $cp_livraison;
private ?string $commune_livraison;
private ?string $latitude;
private ?string $longitude;
private int $pret_materiel;
private int $quantite;
private ?float $remise;
private ?float $total_livraison;
private ?float $total_ttc;
private ?DateTime $created_at;

public function __construct(
    int $id = 0,
    int $utilisateur_id = 0,
    int $menu_id = 0,
    int $commande_etat_id = 1,
    ?string $numero = null,
    ?DateTime $date = null,
    ?string $adresse_livraison = null,
    ?string $cp_livraison = null,
    ?string $commune_livraison = null,
    ?float $latitude = null,
    ?float $longitude = 0,
    int $pret_materiel = 0,
    ?float $quantite = 0,
    ?float $total_livraison = null,
    ?float $total_ttc = null,
    ?float $remise = null,
    ?DateTime $created_at = new DateTime(),
)
{
    $this->setId($id);
    $this->setUtilisateur_id($utilisateur_id);
    $this->setMenu_id($menu_id);
    $this->setCommande_etat_id($commande_etat_id);
    $this->setNumero($numero);
    $this->setDate($date);
    $this->setAdresse_livraison($adresse_livraison);
    $this->setCp_livraison($cp_livraison);
    $this->setCommune_livraison($commune_livraison);
    $this->setLatitude($latitude);
    $this->setLongitude($longitude);
    $this->setPret_materiel($pret_materiel);
    $this->setQuantite($quantite);
    $this->setTotal_livraison($total_livraison);
    $this->setTotal_ttc($total_ttc);
    $this->setRemise($remise);
    $this->setCreated_at($created_at);
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
public function getAdresse_livraison(): ?string
{
    return $this->adresse_livraison;
}
public function getCp_livraison(): ?string
{
    return $this->cp_livraison;
}
public function getCommune_livraison(): ?string
{
    return $this->commune_livraison;
}
public function getLatitude(): ?float
{
    return $this->latitude;
}
public function getLongitude(): ?float
{
    return $this->longitude;
}
public function getPret_materiel(): int
{
    return $this->pret_materiel;
}
public function getRemise(): ?float
{
    return $this->remise;
}
public function getQuantite(): int
{
    return $this->quantite;
}
public function getTotal_livraison(): ?float
{
    return $this->total_livraison;
}
public function getTotal_ttc(): ?float
{
    return $this->total_ttc;
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
public function setAdresse_livraison(?string $adresse_livraison): void
{
    $this->adresse_livraison = $adresse_livraison;
}
public function setCp_livraison(?string $cp_livraison): void
{
    $this->cp_livraison = $cp_livraison;
}
public function setCommune_livraison(?string $commune_livraison): void
{
    $this->commune_livraison = $commune_livraison;
}
public function setLatitude(?float $latitude): void
{
    $this->latitude = $latitude;
}
public function setLongitude(?float $longitude): void
{
    $this->longitude = $longitude;
}
public function setQuantite(int $quantite): void
{
    $this->quantite = $quantite;
}
public function setPret_materiel (int $pret_materiel): void
{
    $this->pret_materiel = $pret_materiel;
}
public function setRemise(?float $remise): void
{
    $this->remise = $remise;
}
public function setTotal_livraison(?float $total_livraison): void
{
    $this->total_livraison = $total_livraison;
}
public function setTotal_ttc(?float $total_ttc): void
{
    $this->total_ttc = $total_ttc;
}
public function setCreated_at(?DateTime $created_at): void
{
    $this->created_at = $created_at;
}
}
