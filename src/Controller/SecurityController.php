<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/login', name: 'login', methods: ['GET','POST'])]
    public function login(Request $request): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        if ($request->isMethod('POST'))
        {
            $userData = $this->userRepository->authenticate($email, $password);

            if ($userData) {
                // Stocke les infos utilisateur en session
                $session = $request->getSession();
                $session->set('user', $userData);

                $redirect = str_replace('/', '', $this->getTargetPath($request->getSession(), 'main'));

                if ($redirect == '' || $redirect == 'home')
                {
                    $redirect = 'home';
                } else
                {
                    $redirect .= '_index';
                }

                $this->addFlash('success', 'Connexion réussie');
                return $this->redirectToRoute($redirect);
            } else {
                $this->addFlash('error', 'Email ou mot de passe incorrect');
            }
        }

        // Gestion de la redirection
        if ($redirect = $request->query->get('redirect')) {
            $this->saveTargetPath($request->getSession(), 'main', $redirect);
        }

        return $this->render('security/login.html.twig', ['email' => $email]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request)
    {
        $session = $request->getSession();
        $session->remove('user');

        return $this->redirectToRoute('login');
    }

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        if ($request->isMethod('POST')) {

            $token = new CsrfToken('register', $request->request->get('_csrf_token'));
            if (!$csrfTokenManager->isTokenValid($token)) {
                throw $this->createAccessDeniedException('CSRF invalide');
            }

            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirm = $request->request->get('confirm_password');

            if ($password !== $confirm) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas');
                return $this->redirectToRoute('register');
            }

            if ($userRepository->isValidPassword($password))
            {
                throw $this->createAccessDeniedException('Le mot de passe doit contenir au moins : 10 caractères, 1 minuscule, 1 majuscule, 1 caractère spécial et 1 chiffre');
            }

            $user = new User();
            $user->setEmail($request->request->get('email'));
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $user->setNom($request->request->get('nom'));
            $user->setPrenom($request->request->get('prenom'));

            $user->setTelephone($request->request->get('telephone'));
            $user->setAdresse($request->request->get('adresse'));
            $user->setCode_postal($request->request->get('code_postal'));
            $user->setCommune($request->request->get('commune'));
            $user->setPays($request->request->get('pays'));
            $user->setPoste($request->request->get('poste') ?? '');

            if ($userRepository->insert($user))
            {
                $this->addFlash('success', 'Compte créé avec succès');
                return $this->redirectToRoute('login', ['email' => $email]);
            }
            else
            {
                $this->addFlash('error', 'Échec de la création du compte');
            }
        }

        return $this->render('security/register.html.twig');
    }

}
