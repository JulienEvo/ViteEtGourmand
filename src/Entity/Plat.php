<?php

namespace App\Entity;

class Plat
{
    private int $id;
    private string $libelle;
    private int $type_id;
    private string $image;
    private bool $actif;

    public function __construct(int $id, string $libelle, int $type_id, string $image, bool $actif)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->type_id = $type_id;
        $this->image = $image;
        $this->actif = $actif;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getLibelle(): string
    {
        return $this->libelle;
    }
    public function getType_id(): int
    {
        return $this->type_id;
    }
    public function getImage(): string
    {
        return $this->image;
    }
    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }
    public function setType_id(int $type_id): void
    {
        $this->type_id = $type_id;
    }
    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
}
