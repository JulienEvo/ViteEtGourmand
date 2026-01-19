<?php

namespace App\Security;

use PDO;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserProvider implements UserProviderInterface
{
    private PDO $pdo;
    private UserRepository $userRepository;
    public function __construct(PDO $pdo, UserRepository $userRepository) {
        $this->pdo = $pdo;
        $this->userRepository = $userRepository;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->findByEmail($identifier);

        if (!$user) {
            throw new UserNotFoundException('Utilisateur non trouvé');
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException("Utilisateur non supporté");
        }
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}
