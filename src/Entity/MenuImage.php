<?php

namespace App\Entity;

use DateTime;

class MenuImage
{
    private int $id;
    private int $menu_id;
    private string $fichier;
    private string $titre;

    public function __construct(int $id, int $menu_id, string $fichier, string $titre)
    {
        $this->setId($id);
        $this->setMenuId($menu_id);
        $this->setFichier($fichier);
        $this->setTitre($titre);
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getMenuId(): int
    {
        return $this->menu_id;
    }
    public function getFichier(): string
    {
        return $this->fichier;
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
    public function setFichier(string $fichier): void
    {
        $this->fichier = $fichier;
    }
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }
}
