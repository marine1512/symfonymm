<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart')]
    public function index(Request $request): Response
    {
        // Récupération du panier en session (tableau des articles)
        $cart = $request->getSession()->get('cart', []);

        // Calcul du prix total
        $totalPrice = array_reduce($cart, function ($total, $item) {
            return $total + $item['price'] * $item['quantity'];
        }, 0);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
public function addToCart($id, Request $request): Response
{
    // Exemple de données mockées pour l'article (en vrai, récupéré depuis la base de données)
    $product = [
        'id' => $id,
        'name' => 'Produit ' . $id,
        'price' => 20, // Exemple de prix
        'quantity' => 1,
    ];

    // Récupérer le panier en session
    $session = $request->getSession();
    $cart = $session->get('cart', []);

    // Logic pour vérifier si l'article est déjà dans le panier
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += 1; // Si déjà présent, augmenter la quantité
    } else {
        $cart[$id] = $product; // Sinon, ajouter l'article au panier
    }

    // Stocker le panier mis à jour dans la session
    $session->set('cart', $cart);

    return $this->redirectToRoute('cart');
}
    
    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
public function removeFromCart($id, Request $request): Response
{
    $session = $request->getSession();
    $cart = $session->get('cart', []);

    // Supprimer l'article si présent
    if (isset($cart[$id])) {
        unset($cart[$id]);
    }

    $session->set('cart', $cart);

    return $this->redirectToRoute('cart');
}

}