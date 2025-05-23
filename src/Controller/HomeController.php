<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;

class HomeController extends AbstractController
{
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