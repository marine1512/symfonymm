<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

        
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            // Assigner un rôle par défaut
            $user->setRoles(['ROLE_CLIENT']);

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('mignomarine@gmail.com', 'Mail Bot'))
                    ->to((string) $user->getEmail())
                    ->subject('Merci de confirmer votre mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            $this->addFlash('success', 'Un email de confirmation a été envoyé. Veuillez vérifier votre boîte de réception.');

            return $this->redirectToRoute('app_register_confirmation');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }
    
    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(
        Request $request,
        TranslatorInterface $translator,
        EntityManagerInterface $entityManager
    ): Response {
        // Restreignez l'accès aux utilisateurs connectés
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    
        $user = $this->getUser();
    
        if (!$user instanceof \App\Entity\User) {
            throw new \LogicException('L\'utilisateur n\'est pas une instance de App\Entity\User.');
        }
    
        // Mettre à jour l'état vérifié du compte
        $user->setIsVerified(true);
        $entityManager->flush();
    
        // Connectez automatiquement l'utilisateur
        $this->addFlash('success', 'Votre email a été confirmé.');
        // Redirection vers la page d'accueil après la connexion
        return $this->redirectToRoute('home');
    }
    
    #[Route('/register/confirmation', name: 'app_register_confirmation')]
    public function confirmEmailNotification(): Response
    {
        return $this->render('registration/confirmation_email.html.twig');
    }
}