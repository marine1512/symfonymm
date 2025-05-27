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
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Inscription")
 */
class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

        /**
     * Inscription d'un nouvel utilisateur.
     *
     * @OA\Post(
     *     path="/register",
     *     summary="Créer un compte utilisateur",
     *     description="Permet aux nouveaux utilisateurs de s'enregistrer en créant un compte.",
     *     tags={"Inscription"},
     *     @OA\RequestBody(
     *         description="Les données d'inscription",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", example="test@example.com"),
     *             @OA\Property(property="plainPassword", type="string", example="strongpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulaire d'inscription affiché ou envoi de mail de confirmation."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur lors de la soumission du formulaire ou données non valides."
     *     )
     * )
     */
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
    
    /**
     * Confirmation du mail utilisateur.
     *
     * @OA\Get(
     *     path="/verify/email",
     *     summary="Vérification de l'email",
     *     description="Permet la vérification de l'adresse email de l'utilisateur après inscription.",
     *     tags={"Inscription"},
     *     @OA\Response(
     *         response=200,
     *         description="Email vérifié avec succès."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Accès refusé si l'utilisateur n'est pas connecté."
     *     )
     * )
     */
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
    
    /**
     * Notification de confirmation d'email.
     *
     * @OA\Get(
     *     path="/register/confirmation",
     *     summary="Afficher la notification de confirmation.",
     *     tags={"Inscription"},
     *     @OA\Response(
     *         response=200,
     *         description="Page de notification affichée avec succès."
     *     )
     * )
     */
    #[Route('/register/confirmation', name: 'app_register_confirmation')]
    public function confirmEmailNotification(): Response
    {
        return $this->render('registration/confirmation_email.html.twig');
    }
}