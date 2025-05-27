<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Sécurité", description="Endpoints pour la gestion de la sécurité et de l'authentification.")
 */
class SecurityController extends AbstractController
{

      /**
     * Connexion de l'utilisateur.
     * 
     * @OA\Post(
     *     path="/login",
     *     summary="Connexion de l'utilisateur",
     *     tags={"Sécurité"},
     *     description="Affiche le formulaire de connexion et gère l'authentification utilisateur.",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="username", type="string", example="user@example.com"),
     *                  @OA\Property(property="password", type="string", example="password")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Succès : l'utilisateur est connecté.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Connexion réussie.")
     *          )
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Erreur d'authentification.",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Identifiants invalides.")
     *          )
     *     )
     * )
     */
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
 
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * Endpoint de vérification de connexion.
     *
     *
     * @OA\Post(
     *     path="/login_check",
     *     summary="Vérifier les informations d'identification de connexion.",
     *     tags={"Sécurité"},
     *     description="Traite les informations d'identification de connexion soumises.",
     *     @OA\Response(
     *          response=204,
     *          description="La connexion est gérée par le système de sécurité Symfony."
     *     )
     * )
     */
    #[Route(path: '/login_check', name: 'app_login_check')]
public function loginCheck(): void
{
    throw new \LogicException('This method can be blank - it will be intercepted by your security system.');
}

    /**
     * Déconnexion de l'utilisateur.
     *
     *
     * @OA\Get(
     *     path="/logout",
     *     summary="Déconnexion de l'utilisateur.",
     *     tags={"Sécurité"},
     *     description="Déconnecte l'utilisateur et termine la session.",
     *     @OA\Response(
     *          response=204,
     *          description="La déconnexion est gérée par le système de sécurité Symfony."
     *     )
     * )
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère automatiquement la déconnexion
    }
}