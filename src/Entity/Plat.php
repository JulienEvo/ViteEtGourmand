<?php

namespace App\Entity;

class Plat
{
    private int $id;
    private string $titre;
    private int $typeId;
    private int $imageId;

    public function __construct(int $id, string $titre, int $typeId, int $imageId)
    {
        $this->id = $id;
        $this->titre = $titre;
        $this->typeId = $typeId;
        $this->imageId = $imageId;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getTitre(): string
    {
        return $this->titre;
    }
    public function getTypeId(): int
    {
        return $this->typeId;
    }
    public function getImageId(): int
    {
        return $this->imageId;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }
    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }
    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }
}
