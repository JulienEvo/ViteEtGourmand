<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserProvider implements UserProviderInterface
{
    public function __construct(private UserRepository $repo) {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->repo->findByEmail($identifier);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}
