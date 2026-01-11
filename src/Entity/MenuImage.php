<?php

namespace App\Entity;

use DateTime;

class MenuImage
{
    private int $id;
    private int $menu_id;
    private string $nom;
    private string $titre;

    public function __construct()
    {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getMenuId(): int
    {
        return $this->menu_id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setMenuId(int $menu_id): void
    {
        $this->menu_id = $menu_id;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }
}
