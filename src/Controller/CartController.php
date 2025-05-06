<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/panier/ajouter/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart(int $id, Request $request): Response
    {
        // Récupérer ou initialiser le panier dans la session
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // Ajouter ou incrémenter la quantité du produit
        if (!array_key_exists($id, $cart)) {
            $cart[$id] = 1;
        } else {
            $cart[$id]++;
        }

        // Enregistrer le panier dans la session
        $session->set('cart', $cart);

        // Rediriger vers la boutique ou une autre page
        return $this->redirectToRoute('shop');
    }


    #[Route('/panier', name: 'cart')]
public function index(Request $request): Response
{
    $session = $request->getSession();
    $cart = $session->get('cart', []);

    // Exemple de liste de produits statiques
    $products = [
        1 => ['name' => 'Sweat bleu', 'price' => 29.99],
        2 => ['name' => 'T-shirt noir', 'price' => 19.99],
        3 => ['name' => 'Sac à dos', 'price' => 49.99],
    ];

    // Calcul du contenu et du total du panier
    $cartWithData = [];
    $total = 0;

    foreach ($cart as $id => $quantity) {
        if (isset($products[$id])) {
            $product = $products[$id];
            $cartWithData[] = [
                'product' => $product,
                'quantity' => $quantity,
                'total_price' => $product['price'] * $quantity,
            ];
            $total += $product['price'] * $quantity;
        }
    }

    return $this->render('cart/index.html.twig', [
        'cart' => $cartWithData,
        'total' => $total,
    ]);
}
}
