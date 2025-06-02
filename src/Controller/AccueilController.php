<?php

namespace App\Controller;

use App\Repository\SweatshirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe contrôleur pour gérer la page d'accueil.
 *
 * Cette classe est responsable de l'affichage de la page d'accueil,
 * y compris la récupération des produits promus et la vérification
 * de l'état de connexion de l'utilisateur.
 */
final class AccueilController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * Cette méthode récupère les produits promus via le repository
     * et vérifie si l'utilisateur est connecté avant d'envoyer les
     * données à un template Twig pour affichage.
     *
     * @param SweatshirtRepository $sweatshirtRepository Le repository permettant de récupérer les sweatshirts promus.
     *
     * @return Response La réponse HTTP contenant la page d'accueil rendue.
     *
     * @throws \LogicException Si un problème lié au rendu ou aux services survient.
     */
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        // Récupérer les produits promus
        $promotedProducts = $sweatshirtRepository->findPromotedSweatshirts();

        // Vérifier si l'utilisateur est connecté
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('accueil/index.html.twig', [
            'promotedProducts' => $promotedProducts,
            'isUserLoggedIn' => $isUserLoggedIn,
        ]);
    }
}