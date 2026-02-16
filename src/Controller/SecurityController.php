<?php

namespace App\Controller;

use App\Controller\Admin\AdminUtilisateurController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/login', name: 'login', methods: ['GET','POST'])]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository, Request $request): Response
    {
        $redirect = $request->query->get('redirect', 'home');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            $this->addFlash('success', "Bienvenue " . $this->getUser()->getPrenom());
            return $this->redirectToRoute($redirect);
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request)
    {}

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserRepository $userRepository, CsrfTokenManagerInterface $csrfTokenManager, HttpClientInterface $httpClient, AdminUtilisateurController $adminUtilisateurController): Response
    {

        if ($request->isMethod('POST')) {

            $token = new CsrfToken('register', $request->request->get('_csrf_token'));
            $email = trim($request->request->get('email'));
            $password = trim($request->request->get('password'));
            $confirm_password = trim($request->request->get('confirm_password'));

            $utilisateur = new User(
                0,
                [$request->request->get('roles', 'ROLE_USER')],
                $email,
                $password,
                trim($request->request->get('prenom')),
                trim($request->request->get('nom')),
                trim($request->request->get('telephone')),
                trim($request->request->get('adresse')),
                trim($request->request->get('code_postal')),
                trim($request->request->get('commune')),
                trim($request->request->get('pays')),
                $request->request->get('latitude'),
                $request->request->get('longitude'),
                trim($request->request->get('poste')) ?? ''
            );

            if (!$csrfTokenManager->isTokenValid($token)) {
                $this->addFlash('danger', 'CSRF invalide');
                return $this->render('security/register.html.twig', ['utilisateur' => $utilisateur]);
            }

            $retValid = $userRepository->isValidUtilisateur($utilisateur, true, true, $confirm_password);
            if ($retValid !== true)
            {
                $this->addFlash('danger', $retValid);
                return $this->render('security/register.html.twig', ['utilisateur' => $utilisateur]);
            }

            if ($userRepository->insert($utilisateur, $httpClient, $adminUtilisateurController))
            {
                $this->addFlash('success', 'Compte créé avec succès');
                return $this->redirectToRoute('login', ['last_username' => $email]);
            }
            else
            {
                $this->addFlash('danger', 'Échec de la création du compte');
            }
        }

        $last_username = $request->query->get('lastUsername', '');
        return $this->render('security/register.html.twig', ['last_username' => $last_username]);
    }

    #[Route('/reinit_pass', name: 'reinit_pass')]
    public function reinit_pass(
        Request $request,
        UserRepository $userRepository,
        MailerInterface $mailer,
        HttpClientInterface $httpClient,
        AdminUtilisateurController $adminUtilisateurController,
    ): Response
    {
        $last_username = $request->query->get('last_username', '');
        $fromUser = $request->query->get('fromUser', 0);

        if ($request->isMethod('POST'))
        {
            $email = $request->request->get('email', '');

            $utilisateur = $userRepository->findByEmail($email);

            // Vérifie si le compte existe en bdd avec cet email
            if (!isset($utilisateur))
            {
                $this->addFlash('danger', "Le compte n'existe pas");
                return $this->redirectToRoute('register', ['last_username' => $email]);
            }

            if (!$fromUser)
            {
                //*** DEMANDE DE REINITIALISATION DU MOT DE PASSE ***//

                // Envoi un lien par mail pour réinitialiser le mot de passe
                $lien_reinit = $this->generateUrl('reinit_pass', ['last_username' => $email, 'fromUser' => 1], UrlGeneratorInterface::ABSOLUTE_URL);
                $lien_contact = $this->generateUrl('admin_societe_contact', [], UrlGeneratorInterface::ABSOLUTE_URL);

                $email = (new Email())
                    ->from('no-reply@vite-et-gourmand.fr')
                    ->to($email)
                    ->subject('Vite & Gourmand - Réinitialisation du mot de passe')
                    ->html("
                            <p>
                                Bonjour {$utilisateur->getPrenom()},
                                <br><br>
                                Veuillez suivre le lien ci-dessous afin de réinitilaiser votre mot de pass :
                                <a href='{$lien_reinit}'>Réinitiliser mon mot de passe</a>
                                <br><br>
                                Si vous avez la moindre question ou besoin d’aide, notre équipe reste à votre disposition via le formulaire de contact du site :
                                <a href='{$lien_contact}'>Poser une question</a>
                                <br><br>
                                Nous vous remercions pour votre confiance et vous souhaitons une excellente expérience culinaire.
                                <br><br>
                                Cordialement,<br>
                                <b>L’équipe Vite & Gourmand</b>
                            </p>
                        "
                    );
                $mailer->send($email);

                $this->addFlash('success', 'Demande de réinitialisation de mot de passe envoyée avec succès');
                return $this->redirectToRoute('login', ['last_username' => $email]);
            }
            else
            {
                //*** REINITIALISATION DU MOT DE PASSE ***//

                $password = $request->request->get('password', '');
                $confirm = $request->request->get('confirm', '');
                $utilisateur->setPassword($password);

                $ret = $userRepository->isValidUtilisateur($utilisateur, false, true, $confirm);
                if ($ret !== true)
                {
                    $this->addFlash('danger', $ret );
                    return $this->render('security/reinit_pass.html.twig', [
                        'last_username' => $email,
                        'fromUser' => 1
                    ]);
                }

                $ret = $userRepository->update($utilisateur, true, $httpClient, $adminUtilisateurController);
                if ($ret === true)
                {
                    $this->addFlash('success', 'Mot de passe réinitialisé avec succès');
                    return $this->redirectToRoute('login', ['last_username' => $email]);
                }
                else
                {
                    $this->addFlash('danger', "Erreur lors de la réinitialisation du mot de passe : ".$ret['message'] );
                }
            }
        }

        return $this->render('security/reinit_pass.html.twig', [
            'last_username' => $last_username,
            'fromUser' => $fromUser
        ]);
    }

}
