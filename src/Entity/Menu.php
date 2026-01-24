<?php

namespace App\Entity;

class Menu
{
    private int $id;
    private string $libelle;
    private string $description;
    private string $conditions;
    private int $min_personne;
    private float $tarif_personne;
    private int $quantite;
    private string $themes;
    private string $regimes;
    private bool $actif;

    public function __construct(
        int $id = 0,
        string $libelle = '',
        string $description = '',
        string $conditions = '',
        int $min_personne = 1,
        float $tarif_personne = 0,
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
        $this->setmin_personne($min_personne);
        $this->settarif_personne($tarif_personne);
        $this->setQuantite($quantite);
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
    public function getMin_personne(): int
    {
        return $this->min_personne;
    }
    public function getTarif_personne(): float
    {
        return $this->tarif_personne;
    }
    public function getQuantite(): int
    {
        return $this->quantite;
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
    public function setMin_personne(int $min_personne): void
    {
        $this->min_personne = $min_personne;
    }
    public function setTarif_personne(float $tarif_personne): void
    {
        $this->tarif_personne = $tarif_personne;
    }
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
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
