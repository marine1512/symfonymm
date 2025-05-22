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
        $user->setEmail('admin@example.com'); // Ajoutez un email (obligatoire si unique)
        $user->setRoles(['ROLE_ADMIN']);
        
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, 'admin');
        $user->setPassword($hashedPassword);
    
        // Sauvegarder dans la base de données
        $entityManager->persist($user);
        $entityManager->flush();
    
        return $this->json(['message' => 'Utilisateur admin créé avec succès']);
    }

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
        $user->setUsername('client'); // Nom d'utilisateur
        $user->setEmail('client@example.com'); // Email fictif ou dynamique
        $user->setRoles(['ROLE_CLIENT']);
    
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, 'client');
        $user->setPassword($hashedPassword);
    
        // Persist et flush
        $entityManager->persist($user);
        $entityManager->flush();
    
        return $this->json(['message' => 'Utilisateur client créé avec succès']);
    }
}