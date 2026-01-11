<?php

namespace App\Repository;

use App\Entity\Plat;
use PDO;

class PlatRepository extends BaseRepository
{
    protected string $table = 'plat';

    protected function map(array $row): Plat
    {
        return new Plat(
            (int)$row['id'],
            $row['titre'],
            (int)$row['type_id'],
            (int)$row['image_id']
        );
    }

    public function insert(Plat $plat): bool
    {
        $sql = "INSERT INTO {$this->table} (titre, type_id, image_id)
                VALUES (:titre, :type_id, :image_id)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'titre' => $plat->getTitre(),
            'type_id' => $plat->getTypeId(),
            'image_id' => $plat->getImageId()
        ]);
    }

    public function update(Plat $plat): bool
    {
        $sql = "UPDATE {$this->table}
                SET titre=:titre, type_id=:type_id, image_id=:image_id
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'titre' => $plat->getTitre(),
            'type_id' => $plat->getTypeId(),
            'image_id' => $plat->getImageId(),
            'id' => $plat->getId()
        ]);
    }
}
