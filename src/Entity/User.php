<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use function Symfony\Component\Clock\now;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    private int $id;
    private array $roles = ['ROLE_USER'];
    private string $email;
    private string $password;
    private string $prenom;
    private string $nom;
    private string $telephone;
    private string $adresse;
    private string $code_postal;
    private string $commune;
    private string $pays;
    private ?string $poste;
    private bool $actif;
    private DateTime $createdAt;
    private ?DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        array $roles = ['ROLE_USER'],
        string $email = '',
        string $password = '',
        string $prenom = '',
        string $nom = '',
        string $telephone = '',
        string $adresse = '',
        string $code_postal = '',
        string $commune = '',
        string $pays = '',
        string $poste = '',
        bool $actif = true,
        dateTime $createdAt = new DateTime,
        DateTime $updatedAt = null
    ) {
        $this->setId($id);
        $this->setRoles($roles);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPrenom($prenom);
        $this->setNom($nom);
        $this->setTelephone($telephone);
        $this->setAdresse($adresse);
        $this->setCode_postal($code_postal);
        $this->setCommune($commune);
        $this->setPays($pays);
        $this->setPoste($poste);
        $this->setActif($actif);
        $this->setCreatedAt($createdAt);
        $this->setUpdatedAt($updatedAt);
    }

    public function getUserId(): int
    {
        return $this->id;
    }
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }
    public function eraseCredentials(): void
    {}

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function getId(): string
    {
        return $this->id;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function getAdresse(): string
    {
        return $this->adresse;
    }
    public function getCode_postal(): string
    {
        return $this->code_postal;
    }
    public function getCommune(): string
    {
        return $this->commune;
    }
    public function getPays(): string
    {
        return $this->pays;
    }
    public function getPoste(): string
    {
        return $this->poste;
    }
    public function getActif(): bool
    {
        return $this->actif;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }
    public function setCode_postal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }
    public function setCommune(string $commune): void
    {
        $this->commune = $commune;
    }
    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }
    public function setPoste(string $poste): void
    {
        $this->poste = $poste;
    }
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
    }
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
