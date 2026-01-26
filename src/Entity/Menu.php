<?php

namespace App\Entity;

class Menu
{
    private int $id;
    private string $libelle;
    private string $description;
    private string $conditions;
    private int $quantite_min;
    private float $tarif_unitaire;
    private int $quantite_disponible;
    private string $themes;
    private string $regimes;
    private bool $actif;

    public function __construct(
        int $id = 0,
        string $libelle = '',
        string $description = '',
        string $conditions = '',
        int $quantite_min = 1,
        float $tarif_unitaire = 0,
        int $quantite = 0,
        bool $actif = true,
        string $themes = '',
        string $regime = ''
    )
    {
        $this->setId($id);
        $this->setLibelle($libelle);
        $this->setDescription($description);
        $this->setConditions($conditions);
        $this->setquantite_min($quantite_min);
        $this->settarif_unitaire($tarif_unitaire);
        $this->setQuantite_disponible($quantite);
        $this->setActif($actif);

        $this->setThemes($themes);
        $this->setRegimes($regime);
    }

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
    public function getConditions(): string
    {
        return $this->conditions;
    }
    public function getQuantite_min(): int
    {
        return $this->quantite_min;
    }
    public function getTarif_unitaire(): float
    {
        return $this->tarif_unitaire;
    }
    public function getQuantite_disponible(): int
    {
        return $this->quantite_disponible;
    }
    public function getThemes(): string
    {
        return $this->themes;
    }
    public function getRegimes(): string
    {
        return $this->regimes;
    }
    public function isActif(): bool
    {
        return $this->actif;
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
    public function setConditions(string $conditions): void
    {
        $this->conditions = $conditions;
    }
    public function setQuantite_min(int $quantite_min): void
    {
        $this->quantite_min = $quantite_min;
    }
    public function setTarif_unitaire(float $tarif_unitaire): void
    {
        $this->tarif_unitaire = $tarif_unitaire;
    }
    public function setQuantite_disponible(int $quantite_disponible): void
    {
        $this->quantite_disponible = $quantite_disponible;
    }
    public function setThemes(string $tab_theme): void
    {
        $this->themes = $tab_theme;
    }
    public function setRegimes(string $tab_regime): void
    {
        $this->regimes = $tab_regime;
    }
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
}
