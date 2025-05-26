<?php

namespace App\Controller;

use App\Repository\SweatshirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

// Ce contrôleur gère toutes les responsabilités de la page d'accueil
final class AccueilController extends AbstractController
{
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