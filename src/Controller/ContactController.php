<?php

//namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;

//class ContactController extends AbstractController
//{
    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
//    public function sendMail(Request $request, MailerInterface $mailer): Response
//    {
//        $request->request->all();

        // Effectuez la validation des données ici (par exemple, avec des validateurs Symfony)

        // Envoyez l'e-mail
//        $email = (new Email());
//        $request->request->get('name');
//        $request->request->get('email');
//        $request->request->get('telephone');
//        $request->request->get('message');

//        $mailer->send($email);

        // Répondez avec un succès
//        return $this->json(['message' => 'Message envoyé avec succès']);
//    }
//}

//namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;

//class ContactController extends AbstractController
//{
    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
//    public function sendMail(Request $request, MailerInterface $mailer): Response
//    {
        // Récupérez les données du formulaire depuis la requête
//        $name = $request->request->get('name');
//        $emailSender = $request->request->get('email');
//        $telephone = $request->request->get('telephone');
//        $messageContent = $request->request->get('message');
//
//        if (!filter_var($emailSender, FILTER_VALIDATE_EMAIL)) {
            // Gérez l'erreur, par exemple en renvoyant une réponse d'erreur
//            return $this->json(['message' => 'Adresse e-mail de l\'expéditeur non valide'], Response::HTTP_BAD_REQUEST);
//        }
        // Effectuez la validation des données ici (par exemple, avec des validateurs Symfony)

        // Créez l'e-mail
//        $email = (new Email())
//            ->from($emailSender) // Utilisez l'adresse e-mail fournie par l'utilisateur comme expéditeur
//            ->to('otrip.contact@gmail.com')
//            ->subject('Nouveau message de contact de ' . $name)
//            ->text('Téléphone: ' . $telephone . "\n\n" . $messageContent);

        // Envoyez l'e-mail
//        $mailer->send($email);

        // Répondez avec un succès
//        return $this->json(['message' => 'Message envoyé avec succès']);
//    }
//}



//namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Mailer\MailerInterface;
//use Symfony\Component\Mime\Email;

//class ContactController extends AbstractController
//{
    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
//    public function sendEmail(Request $request, MailerInterface $mailer, $message): Response
//    {
        // Récupérer les données JSON de la requête
//        $requestData = json_decode($request->getContent(), true);

        // Récupérer les détails de l'e-mail du front-end React
//        $name = $requestData['name'];
//        $emailSender = $requestData['emailSender'];
//        $telephone = $requestData['telephone'];
//        $message = $request->get('message');
        // Créer un objet Email
//        $email = (new Email())
//            ->from($emailSender) // Adresse expéditeur
//            ->to('otrip.contact@gmail.com') // Adresse destinataire (personnalisez selon vos besoins)
//            ->subject('Sujet de l\'e-mail') // Sujet de l'e-mail (personnalisez selon vos besoins)
//            ->text("Nom: $name\nTéléphone: $telephone\nMessage: $message"); // Contenu texte de l'e-mail

        // Envoyer l'e-mail
//        $mailer->send($email);

        // Répondre avec une réponse JSON
//        return new JsonResponse(['message' => 'E-mail envoyé avec succès']);
//    }
//}

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"POST"})
     */
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        $requestData = json_decode($request->getContent(), true);
        $name = $requestData['name'];
        $recipient = $requestData['email'];
        $phone = $requestData['telephone'];
        $message = $requestData['message'];

        if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {

            $email = (new Email())
                ->from($recipient)
                ->to('admin@gmail.com')
                ->subject('contact')
                ->text($message);

            $mailer->send($email);

            return $this->json(['message' => 'Merci pour votre message, nous revenons vers vous rapidement.']);
        } else {
            return $this->json(['error' => 'Adresse e-mail non valide'], 400);
        }
    }
}