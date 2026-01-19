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
            $emailExpediteur = $request->request->get('email');
            $message = $request->request->get('message');

            // Sécurité minimale
            if (!$nom || !$emailExpediteur || !$message) {
                $this->addFlash('error', 'Tous les champs sont obligatoires');
                return $this->redirectToRoute('contact');
            }

            $email = (new Email())
                ->from($emailExpediteur)
                ->to('contact@monsite.fr')
                ->subject('Message depuis le formulaire de contact')
                ->text(
                    "Nom : $nom\n".
                    "Email : $emailExpediteur\n\n".
                    "Message :\n$message"
                );

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig');
    }
}
