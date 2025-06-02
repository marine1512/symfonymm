<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;

/**
 * Contrôleur HomeController.
 *
 * Ce contrôleur est responsable de la gestion de la route "/home",
 * incluant l'affichage des produits promus et la vérification de
 * l'état de connexion de l'utilisateur pour personnaliser la vue.
 */
class HomeController extends AbstractController
{
    /**
     * Méthode principale du contrôleur qui affiche la page d'accueil.
     * 
     * Cette méthode se charge de récupérer les produits promus
     * via le repository et de transmettre les données nécessaires
     * à la vue Twig associée.
     *
     * @param SweatshirtRepository $sweatshirtRepository Service permettant d'accéder aux sweatshirts promus depuis la base de données.
     * 
     * @return Response Une réponse HTTP avec le rendu HTML de la page d'accueil.
     */
    #[Route('/home', name: 'home')]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        // Récupération des produits promus
        $promotedProducts = $sweatshirtRepository->findPromotedSweatshirts();

        // Vérification si l'utilisateur est connecté
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('home/index.html.twig', [
            'promotedProducts' => $promotedProducts,
            'isUserLoggedIn' => $isUserLoggedIn,
        ]);
    }
}