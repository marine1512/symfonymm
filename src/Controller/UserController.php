<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/create-admin', name: 'create_admin', methods: ['POST'])]
    public function createUser(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        // Créer une nouvelle instance de User
        $user = new User();
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);

        // Hacher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, 'admin'); 
        $user->setPassword($hashedPassword);

        // Persister l'utilisateur dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();

        // Retourner une réponse (facultatif, utile pour l'API REST)
        return $this->json(['message' => 'Utilisateur créé avec succès']);
    }

    #[Route('/create-client', name: 'create_client', methods: ['POST'])]
public function createClient(
    EntityManagerInterface $entityManager,
    UserPasswordHasherInterface $passwordHasher
): JsonResponse {
    // Créer un utilisateur client
    $user = new User();
    $user->setUsername('client'); // Nom d'utilisateur
    $user->setRoles(['ROLE_CLIENT']); // Définir le rôle client

    // Hacher le mot de passe
    $hashedPassword = $passwordHasher->hashPassword($user, 'client');
    $user->setPassword($hashedPassword);

    // Sauvegarder l'utilisateur dans la base de données
    $entityManager->persist($user);
    $entityManager->flush();

    return $this->json(['message' => 'Utilisateur client créé avec succès']);
}
}