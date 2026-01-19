<?php

namespace App\Controller\Admin;

use App\Controller\MailController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/admin/utilisateur', name: 'admin_utilisateur_')]
class AdminUtilisateurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $type = $request->query->get('type', '');

        $this->denyAccessUnlessGranted('ROLE_USER');
        switch ($type)
        {
            case 'admin':
                $role = 'ROLE_ADMIN';
                break;
            case 'employe':
                $role = 'ROLE_EMPLOYE';
                break;
            default:
                $role = 'ROLE_USER';
                break;
        }

        $tabUtilisateur = $userRepository->findAll($role);

        return $this->render('admin/utilisateur/index.html.twig', [
            'tabUtilisateur' => $tabUtilisateur,
            'type' => $type
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(int $id, UserRepository $userRepository, Request $request, MailerInterface $mailer): Response
    {
        $mode = $request->query->get('mode');
        $type = $request->query->get('type');

        //echo "TEST : " . $mode .' - '.$type; exit;
        //FonctionsService::p($request->request->get('role')); exit;

        //--- VALIDATION DU FORMULAIRE ---//
        if ($request->isMethod('POST')) {

            $roles = [$request->request->get('role')];
            $nom = trim($request->request->get('nom'));
            $prenom = trim($request->request->get('prenom'));
            $email = trim($request->request->get('email'));
            $password = trim($request->request->get('password'));
            $confirm = trim($request->request->get('confirm'));

            $utilisateur = new User(
                $id,
                $roles,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $prenom,
                $nom,
                trim($request->request->get('telephone')),
                trim($request->request->get('adresse')),
                trim($request->request->get('code_postal')),
                trim($request->request->get('commune')),
                trim($request->request->get('pays')),
                trim($request->request->get('poste')),
                $request->request->get('actif'),
                new DateTime(),
                new DateTime(),
            );

            if ($mode == "ajout")
            {
                //*** INSERT ***//
                echo "TEST : " . $type . ' - ' . ($type != 'employe');

                $ret = $userRepository->isValidUtilisateur($utilisateur, $confirm, $type != 'employe');
                if ($ret !== true)
                {
                    $this->addFlash('danger', $ret );

                    return $this->render('admin/utilisateur/edit.html.twig', [
                        'id' => $id,
                        'utilisateur' => $utilisateur,
                        'mode' => $mode,
                        'type' => $type,
                    ]);
                }

                $ret = $userRepository->insert($utilisateur);

                if (!is_array($ret) )
                {
                    $id = $ret;

                    // Envoi d'un mail à l'utilisateur
                    $lienConnexion = $this->generateUrl('login', [], UrlGeneratorInterface::ABSOLUTE_URL);

                    $email = (new Email())
                        ->from('no-reply@vite-et-gourmand.fr')
                        ->to($utilisateur->getEmail())
                        ->subject('Bienvenue sur Vite & Gourmand')
                        ->html("
                            <p>
                                Bonjour {$utilisateur->getPrenom()},
                                <br><br>
                                Nous vous confirmons que votre compte a bien été créé sur notre site de livraison de menus.
                                <br><br>
                                Vous pouvez dès à présent :
                                <br>
                                <ul>
                                    <li>consulter l’ensemble de nos menus,</li>
                                    <li>passer vos commandes en ligne,</li>
                                    <li>suivre vos livraisons,</li>
                                    <li>gérer vos informations personnelles depuis votre espace client.</li>
                                </ul>
                                <br>
                                Pour accéder à votre espace client :
                                <a href='{$lienConnexion}'>Se connecter</a>
                                <br><br>
                                Si vous avez la moindre question ou besoin d’aide, notre équipe reste à votre disposition via le formulaire de contact du site.
                                <br><br>
                                Nous vous remercions pour votre confiance et vous souhaitons une excellente expérience culinaire.
                                <br><br>
                                Cordialement,<br>
                                <b>L’équipe Vite & Gourmand</b>
                            </p>
                        "
                        );
                    $mailer->send($email);

                    $this->addFlash('success', 'Employé ajouté avec succès');
                }
                else
                {
                    $this->addFlash('danger', "Erreur lors de l'ajout de l'employé : ".$ret['message'] );
                }
            }
            else
            {
                //*** UPDATE ***//

                $ret = $userRepository->update($utilisateur, $password != "");
                if ($ret === true)
                {
                    $this->addFlash('success', 'Employé modifié avec succès');
                }
                else
                {
                    $this->addFlash('danger', "Erreur lors de la modification de l'employé : ".$ret['message'] );
                }
            }

            return $this->render('admin/utilisateur/edit.html.twig', [
                'id' => $id,
                'utilisateur' => $utilisateur,
                'mode' => 'modif',
                'type' => $type,
            ]);
        }

        // Récupère l'employé par son ID
        $utilisateur = $userRepository->findById($id);

        // Affiche l'employé
        return $this->render('admin/utilisateur/edit.html.twig', [
            'id' => $id,
            'utilisateur' => $utilisateur,
            'mode' => $mode,
            'type' => $type,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        //= À TESTER avec erreur
        $ret = $userRepository->delete($id);

        if ($ret)
            {
                $this->addFlash('success', 'Employé supprimé avec succès');
            }
        else
            {
                $this->addFlash('danger', 'Une erreur est survenue lors de l’enregistrement : '.$ret);
            }

        return $this->redirectToRoute('admin_utilisateur_index');
    }
}
