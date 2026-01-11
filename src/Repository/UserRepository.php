<?php

namespace App\Repository;

use App\Entity\User;
use PDO;
use DateTime;

class UserRepository
{
    protected PDO $pdo;

    /*
    protected function map(array $row): User
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setRoles(json_decode($row['roles'], true));
        $user->setEmail($row['email']);
        $user->setPassword($row['password']);
        $user->setNom($row['nom']);
        $user->setPrenom($row['prenom']);
        $user->setTelephone($row['telephone']);
        $user->setAdresse($row['adresse']);
        $user->setCode_postal($row['code_postal']);
        $user->setCommune($row['commune']);
        $user->setPays($row['pays']);
        $user->setPoste(($row['poste'] != null) ? $row['poste'] : "",);
        $user->setActif($row['actif'],);
        $user->setUpdatedAt($row['updated_at'] ? new DateTime($row['updated_at']) : null);

        return $user;
    }
    */

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(User $user): bool
    {
        $sql = "INSERT INTO utilisateur
                    (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
                VALUES
                    (:roles, :email, :password, :prenom, :nom, :telephone, :adresse, :code_postal, :commune, :pays, :poste, :created_at)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'roles' => json_encode($user->getRoles()),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'code_postal' => $user->getCode_postal(),
            'commune' => $user->getCommune(),
            'pays' => $user->getPays(),
            'poste' => $user->getPoste(),
            'created_at' => date('Y-m-d H:i:s') //$user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function update(User $user): bool
    {
        $sql = "UPDATE utilisateur
                SET roles=:roles, email=:email, password=:password, prenom=:prenom, nom=:nom, telephone=:telephone, adresse=:adresse,
                    code_postal=:code_postal, commune=:commune, pays=:pays, poste=:poste, actif=:actif, updated_at=:updated
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'roles' => json_encode($user->getRoles()),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'code_postal' => $user->getCode_postal(),
            'commune' => $user->getCommune(),
            'pays' => $user->getPays(),
            'poste' => $user->getPoste(),
            'actif' => $user->getActif(),
            'updated' => date('Y-m-d'),
            'id' => $user->getId()
        ]);
    }

    public function findAll(): array
    {
        $sql = "SELECT *
                FROM utilisateur
                ORDER BY nom, prenom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $utilisateur_id): User
    {
        $sql = "SELECT *
                FROM utilisateur
                WHERE id = :utilisateur_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT *
                FROM utilisateur
                WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new User(
            $row['id'],
            json_decode($row['roles']),
            $row['email'],
            $row['password'],
            $row['prenom'],
            $row['nom'],
            $row['telephone'],
            $row['adresse'],
            $row['code_postal'],
            $row['commune'],
            $row['pays'],
            $row['poste'],
            $row['actif'],
            new DateTime($row['cereated_at']),
            new DateTime($row['updated_at'])
        );
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        // Vérifie le mot de passe
        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        // Connexion réussie, retourne les infos essentielles
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'poste' => $user->getPoste(),
            'actif' => $user->getActif(),
            'roles' => $user->getRoles(),
        ];
    }
}
