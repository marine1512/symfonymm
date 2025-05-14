<?php

namespace App\Controller;

use App\Repository\SweatshirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        // Récupération des produits promus
        $promotedProducts = $sweatshirtRepository->findPromotedSweatshirts();

        // Vérification si l'utilisateur est connecté
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('accueil/index.html.twig', [
            'promotedProducts' => $promotedProducts,
            'isUserLoggedIn' => $isUserLoggedIn,
        ]);
    }
}