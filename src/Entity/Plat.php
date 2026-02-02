<?php

namespace App\Entity;

class Plat
{
    private int $id;
    private string $libelle;
    private string $description;
    private int $type_id;
    private string $image;
    private bool $actif;

    public function __construct(int $id = 0, string $libelle = '', $description = '', int $type_id = 0, string $image = '', bool $actif = true)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
        $this->setDescription($description);
        $this->setType_id($type_id);
        $this->setImage($image);
        $this->setActif($actif);
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
    public function setId(int $id): void
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
