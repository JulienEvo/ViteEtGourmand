<?php

namespace App\Repository;

use App\Service\FonctionsService;
use PDO;
class PlatAllergeneRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(int $plat_id, array $tab_allergenes): bool|array
    {
        $retour = $this->delete($plat_id);

        if (is_array($retour))
        {
            return $retour;
        }

        foreach ($tab_allergenes as $allergene_id)
        {
            $sql = "INSERT INTO plat_allergene (plat_id, allergene_id)
                    VALUES (:plat_id, :allergene_id)";
            $stmt = $this->pdo->prepare($sql);

            $res = $stmt->execute([
                ':plat_id' => $plat_id,
                ':allergene_id' => $allergene_id
            ]);

            if (!$res)
            {
                return false;
            }
        }

        return true;
    }

    public function delete(int $plat_id): bool|array
    {
        $sql = "DELETE FROM plat_allergene WHERE plat_id = :plat_id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['plat_id' => $plat_id]))
        {
            return true;
        }
        else
        {
            return $stmt->errorInfo();
        }
    }

    public function findAllIdByPlatId($plat_id): array
    {
        $retour = [];

        $sql = "SELECT *
                FROM plat_allergene
                WHERE plat_id = :plat_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['plat_id' => $plat_id]);

        while ($row = $stmt->fetch())
        {
            $retour[] = $row['allergene_id'];
        }

        return $retour;
    }

    public function findAllLibelleByPlatId($plat_id): array
    {
        $retour = [];

        $sql = "SELECT allergene.libelle
                FROM allergene
                INNER JOIN plat_allergene ON plat_allergene.allergene_id = allergene.id
                WHERE plat_allergene.plat_id = :plat_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['plat_id' => $plat_id]);

        while ($row = $stmt->fetch())
        {
            $retour[] = $row['libelle'];
        }

        return $retour;
    }

}
