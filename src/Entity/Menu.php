<?php

namespace App\Entity;

use App\Repository\MenuImageRepository;
use App\Repository\MenuRegimeRepository;
use App\Repository\MenuThemeRepository;

class Menu
{
    private int $id;
    private string $titre;
    private string $description;
    private int $minPersonne;
    private float $tarifPersonne;
    private int $quantite;
    private array $themes;
    private array $regimes;
    private array $images;
    private bool $actif;

    public function __construct(
        int $id,
        string $titre,
        string $description,
        int $minPersonne,
        float $tarifPersonne,
        int $quantite,
        bool $actif,
        array $menu_themes,
        array $menu_regime,
        array $menu_images
    )
    {
        $this->setId($id);
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setMinPersonne($minPersonne);
        $this->setTarifPersonne($tarifPersonne);
        $this->setQuantite($quantite);
        $this->setActif($actif);

        $this->setThemes($menu_themes);
        $this->setRegime($menu_regime);
        $this->setImages($menu_images);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTitre(): string
    {
        return $this->titre;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getMinPersonne(): int
    {
        return $this->minPersonne;
    }
    public function getTarifPersonne(): float
    {
        return $this->tarifPersonne;
    }
    public function getQuantite(): int
    {
        return $this->quantite;
    }
    public function getImages(): array
    {
        return $this->images;
    }
    public function getThemes(): array
    {
        return $this->themes;
    }
    public function getRegime(): array
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
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setMinPersonne(int $minPersonne): void
    {
        $this->minPersonne = $minPersonne;
    }
    public function setTarifPersonne(float $tarifPersonne): void
    {
        $this->tarifPersonne = $tarifPersonne;
    }
    public function setQuantite(int $quantite): void
    {
        $this->quantite = $quantite;
    }
    public function setImages(array $tab_images): void
    {
        $this->images = $tab_images;
    }
    public function setThemes(array $tab_theme): void
    {
        $this->themes = $tab_theme;
    }
    public function setRegime(array $tab_regime): void
    {
        $this->regimes = $tab_regime;
    }
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
}
