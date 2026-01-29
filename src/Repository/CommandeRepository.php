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
        $sql = "INSERT INTO commande (utilisateur_id, menu_id, commande_etat_id, numero, date, quantite, total_ttc, remise)
                VALUES (:utilisateur_id, :menu_id, :etat, :numero, :date, :quantite, :total_ttc, :remise)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([
            'utilisateur_id' => $commande->getUtilisateur_id(),
            'menu_id' => $commande->getMenu_id(),
            'etat' => $commande->getCommande_etat_id(),
            'numero' => $commande->getNumero(),
            'date' => $commande->getDate()?->format('Y-m-d H:i:s'),
            'adresse_livraison' => $commande->getAdresse_livraison(),
            'cp_livraison' => $commande->getCp_livraison(),
            'commune_livraison' => $commande->getCommune_livraison(),
            'latitude' => $commande->getLatitude(),
            'longitude' => $commande->getLongitude(),
            'quantite' => $commande->getQuantite(),
            'total_ttc' => $commande->getTotal_ttc(),
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

    public function delete(int $commande_id): bool|array
    {
        $sql = "UPDATE commande
                SET commande_etat_id = 8
                WHERE id = :commande_id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([':commande_id' => $commande_id]))
        {
            return true;
        }
        else
        {
            return $stmt->errorInfo();
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

        $sql .= " ORDER BY commande.date DESC";

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
                $row->adresse_livraison,
                $row->cp_livraison,
                $row->commune_livraison,
                $row->latitude,
                $row->longitude,
                $row->quantite,
                $row->total_ttc,
                $row->remise,
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
                $row->adresse_livraison,
                $row->cp_livraison,
                $row->commune_livraison,
                $row->latitude,
                $row->longitude,
                $row->quantite,
                $row->total_ttc,
                $row->remise,
                new DateTime($row->created_at)
            );
        }

        return $commande;
    }

    public function getNumero(): string
    {
        $retour = "C".date('ym')."0001";

        $sql = "SELECT MAX(numero) AS numero
                FROM commande";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row)
        {
            $numero = substr($row['numero'], -4);
            $numero++;

            $retour = "C".date('ym') . str_pad($numero, 4, '0', STR_PAD_LEFT);;
        }

        return $retour;
    }

}
