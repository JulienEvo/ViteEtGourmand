<?php

namespace App\Repository;

use App\Entity\Commande;
use PDO;
use DateTime;

class CommandeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Commande $commande): bool
    {
        $sql = "INSERT INTO commande (user_id, etat_id, numero, date, reduction)
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
        $sql = "UPDATE commande
                SET user_id=:uid, etat_id=:etat, numero=:numero, date=:date, reduction=:reduction
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
