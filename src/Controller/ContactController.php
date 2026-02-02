<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {

            $nom = $request->request->get('nom');
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            // Sécurité minimale
            if (!$nom || !$email || !$message) {
                $this->addFlash('danger', 'Tous les champs sont obligatoires');
                return $this->redirectToRoute('contact');
            }

            $email = (new Email())
                ->from($email)
                ->to('contact@monsite.fr')
                ->subject('V&G : Message depuis le formulaire de contact')
                ->text(
                    "Bonjour,\n\n".
                    "Vous avez reçu un nouveau message : \n".
                    " - Nom : $nom\n".
                    " - Email : $email\n\n".
                    " - Message :\n$message\n\n".
                    "Bien cordialement.\n".
                    "Vite & Gourmand"
                );

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
