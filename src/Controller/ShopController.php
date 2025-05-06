<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    #[Route('/boutique', name: 'shop')]
    public function index(): Response
    {
        $products = [
            // Produit fictif (vous pouvez remplacer par des données dynamiques depuis votre base de données)
            ['name' => 'Sweat bleu', 'price' => 29.99, 'description' => 'Un sweat confortable et stylé.'],
            ['name' => 'T-shirt noir', 'price' => 19.99, 'description' => 'Parfait pour les journées estivales.'],
            ['name' => 'Sac à dos', 'price' => 49.99, 'description' => 'Idéal pour transporter vos affaires.'],
        ];

        // Rendu des produits dans la vue Twig
        return $this->render('shop/index.html.twig', [
            'products' => $products,
        ]);
    }
}