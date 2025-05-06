<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté (si existant)

        // Exemple de produits mis en avant (à remplacer par une requête Doctrine dans une vraie base de données)
        $featuredProducts = [
            ['name' => 'Sweat-shirt Blanc', 'price' => 49.99],
            ['name' => 'Sweat-shirt Noir', 'price' => 54.99],
            ['name' => 'Sweat-shirt Bleu', 'price' => 59.99]
        ];

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'featuredProducts' => $featuredProducts,
        ]);
    }
}