<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Service\FonctionsService;
use PDO;
use DateTime;

class CommandeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Commande $commande): int|array
    {
        $sql = "INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, montant_ht, remise)
                VALUES (:utilisateur_id, :menu_id, :etat, :numero, :date, :montant_ht, :remise)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([
            'utilisateur_id' => $commande->getUtilisateur_id(),
            'menu_id' => $commande->getMenu_id(),
            'etat' => $commande->getCommande_etat_id(),
            'numero' => $commande->getNumero(),
            'date' => $commande->getDate()?->format('Y-m-d H:i:s'),
            'montant_ht' => $commande->getMontant_ht(),
            'remise' => $commande->getRemise(),
        ]))
        {
            return $this->pdo->lastInsertId();
        }
        else
        {
            return $this->pdo->errorInfo();
        }
    }

    public function update(Commande $commande): int|array
    {
        $sql = "UPDATE commande
                SET utilisateur_id=:utilisateur_id, commande_etat_id=:commande_etat_id, numero=:numero, date=:date, remise=:remise
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([
            ':utilisateur_id' => $commande->getUtilisateur_id(),
            ':commande_etat_id' => $commande->getCommande_etat_id(),
            ':numero' => $commande->getNumero(),
            ':date' => $commande->getDate()->format('Y-m-d H:i:s'),
            ':remise' => $commande->getRemise(),
            ':id' => $commande->getId()
        ]))
        {
            return $commande->getId();
        }
        else
        {
            return $this->pdo->errorInfo();
        }
    }

    public function findAll(int $utilisateur_id = 0): array
    {
        $vars = [];
        $sql = "SELECT *
                FROM commande
                WHERE 1";

        if ($utilisateur_id > 0)
        {
            $sql .= " AND utilisateur_id = :utilisateur_id";
            $vars['utilisateur_id'] = $utilisateur_id;
        }

        $sql .= " ORDER BY commande.date";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);

        $tabCommandes = [];
        while ($row = $stmt->fetchObject())
        {
            $tabCommandes[$row->id] = new Commande(
                $row->id,
                $row->utilisateur_id,
                $row->menu_id,
                $row->commande_etat_id,
                $row->numero,
                new DateTime($row->date),
                $row->remise,
                $row->montant_ht,
                new DateTime($row->created_at),
            );
        }

        return $tabCommandes;
    }

    public function findById(int $id): ?Commande
    {
        $commande = null;

        $sql = "SELECT *
                FROM commande
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetchObject();

            $commande = new Commande(
                $row->id,
                $row->utilisateur_id,
                $row->menu_id,
                $row->commande_etat_id,
                $row->numero,
                new DateTime($row->date),
                $row->remise,
                $row->montant_ht,
                new DateTime($row->created_at)
            );
        }

        return $commande;
    }

    public function getNumero(): string
    {
        $retour = "C".date('ym')."0001";

        $sql = "SELECT MAX(id), numero
                FROM commande";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $numero = substr($row['numero'], -4);
            $numero++;

            $retour = "C".date('ym') . str_pad($numero, 4, '0', STR_PAD_LEFT);;
        }

        return $retour;
    }

}
