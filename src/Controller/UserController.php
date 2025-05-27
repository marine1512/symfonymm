<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="User Management", description="API pour la gestion des utilisateurs.")
 */

class UserController extends AbstractController
{

    /**
     * @OA\Post(
     *     path="/create-admin",
     *     summary="Créer un utilisateur admin",
     *     description="Créer un utilisateur avec le rôle ADMIN. Retourne une erreur si un admin existe déjà.",
     *     tags={"User Management"},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur admin créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utilisateur admin créé avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Un administrateur existe déjà",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Un administrateur existe déjà.")
     *         )
     *     )
     * )
     */
    #[Route('/create-admin', name: 'create_admin', methods: ['POST'])]
    public function createUser(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Vérifier si un utilisateur admin existe déjà
        $existingAdmin = $entityManager->getRepository(User::class)
            ->findOneBy(['username' => 'admin']);
    
        if ($existingAdmin) {
            return $this->json([
                'error' => 'Un administrateur existe déjà.'
            ], 400);
        }
    
        // Création d'un nouvel utilisateur
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@example.com'); 
        $user->setRoles(['ROLE_ADMIN']);
        
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, 'admin');
        $user->setPassword($hashedPassword);
    
        // Sauvegarder dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();
    
        return $this->json(['message' => 'Utilisateur admin créé avec succès']);
    }

     /**
     * @OA\Post(
     *     path="/create-client",
     *     summary="Créer un utilisateur client",
     *     description="Créer un utilisateur avec le rôle CLIENT. Retourne une erreur si cet utilisateur existe déjà.",
     *     tags={"User Management"},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur client créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Utilisateur client créé avec succès")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Un utilisateur avec ce nom existe déjà",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Un utilisateur avec ce nom existe déjà.")
     *         )
     *     )
     * )
     */
    #[Route('/create-client', name: 'create_client', methods: ['POST'])]
    public function createClient(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Vérifier si l'utilisateur existe déjà
        $existingClient = $entityManager->getRepository(User::class)
            ->findOneBy(['username' => 'client']);
    
        if ($existingClient) {
            return $this->json([
                'error' => 'Un utilisateur avec ce nom existe déjà.'
            ], 400);
        }
    
        // Créer un nouveau client
        $user = new User();
        $user->setUsername('client'); 
        $user->setEmail('client@example.com'); 
        $user->setRoles(['ROLE_CLIENT']);
    
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, 'client');
        $user->setPassword($hashedPassword);
    
        // Persist et flush
        $entityManager->persist($user);
        $entityManager->flush();
    
        return $this->json(['message' => 'Utilisateur client créé avec succès']);
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     summary="Afficher tous les utilisateurs",
     *     description="Affiche une liste des utilisateurs pour l'administration.",
     *     tags={"User Management"},
     *     @OA\Response(
     *         response=200,
     *         description="Retourne une liste des utilisateurs.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function index(): Response
    {
    return $this->render('user/index.html.twig', [
        'users' => [], 
        ]);
    }
}