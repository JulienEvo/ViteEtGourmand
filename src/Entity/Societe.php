<?php

namespace App\Entity;

use DateTime;

class Societe
{
    private int $id;
    private string $libelle;
    private string $type;
    private ?float $capital;
    private ?string $rcs;
    private ?string $tva;
    private string $telephone;
    private string $email;
    private string $adresse;
    private string $code_postal;
    private string $commune;
    private string $pays;
    private bool $actif;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(int $id, string $libelle, string $type, ?float $capital, ?string $rcs, ?string $tva,
                                string $telephone, string $email, string $adresse, string $code_postal, string $commune,
                                string $pays, bool $actif, DateTime $createdAt, ?DateTime $updatedAt = null)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->type = $type;
        $this->capital = $capital;
        $this->rcs = $rcs;
        $this->tva = $tva;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->commune = $commune;
        $this->pays = $pays;
        $this->actif = $actif;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCapital(): ?float
    {
        return $this->capital;
    }

    public function getRcs(): ?string
    {
        return $this->rcs;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getCode_postal(): string
    {
        return $this->code_postal;
    }

    public function getCommune(): string
    {
        return $this->commune;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setCapital(?float $capital): void
    {
        $this->capital = $capital;
    }

    public function setRcs(?string $rcs): void
    {
        $this->rcs = $rcs;
    }

    public function setTva(?string $tva): void
    {
        $this->tva = $tva;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setCode_postal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function setCommune(string $commune): void
    {
        $this->commune = $commune;
    }

    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }

    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
}
