<?php

namespace App\Repository;

use App\Entity\Commande;
use PDO;
use DateTime;

class CommandeRepository extends BaseRepository
{
    protected string $table = 'commande';

    protected function map(array $row): Commande
    {
        return new Commande(
            (int)$row['id'],
            (int)$row['utilisateur_id'],
            (int)$row['etat_id'],
            $row['numero'],
            $row['date'] ? new DateTime($row['date']) : null,
            $row['reduction'] ? new DateTime($row['reduction']) : null
        );
    }

    public function insert(Commande $commande): bool
    {
        $sql = "INSERT INTO {$this->table} (utilisateur_id, etat_id, numero, date, reduction)
                VALUES (:uid, :etat, :numero, :date, :reduction)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'uid' => $commande->getUtilisateurId(),
            'etat' => $commande->getEtatId(),
            'numero' => $commande->getNumero(),
            'date' => $commande->getDate()?->format('Y-m-d H:i:s'),
            'reduction' => $commande->getReduction()?->format('Y-m-d H:i:s')
        ]);
    }

    public function update(Commande $commande): bool
    {
        $sql = "UPDATE {$this->table}
                SET utilisateur_id=:uid, etat_id=:etat, numero=:numero, date=:date, reduction=:reduction
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'uid' => $commande->getUtilisateurId(),
            'etat' => $commande->getEtatId(),
            'numero' => $commande->getNumero(),
            'date' => $commande->getDate()?->format('Y-m-d H:i:s'),
            'reduction' => $commande->getReduction()?->format('Y-m-d H:i:s'),
            'id' => $commande->getId()
        ]);
    }
}
