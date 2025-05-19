<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sweatshirt;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\CartService;
use App\Service\StripeService;

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
    public function addToCart($id, Request $request, ManagerRegistry $doctrine): Response
    {
        // Récupérer le produit depuis la base de données via Doctrine
        $product = $doctrine->getRepository(Sweatshirt::class)->find($id);

        // Vérifiez si le produit existe
        if (!$product) {
            $this->addFlash('error', 'Produit non trouvé.');
            return $this->redirectToRoute('product_list'); // Redirection personnalisée
        }

        // Récupération de la taille sélectionnée depuis le formulaire
        $size = $request->request->get('size');

        // Vérification de la taille et du stock
        $stockBySize = $product->getStockBySize();
        if (!isset($stockBySize[$size]) || $stockBySize[$size] <= 0) {
            $this->addFlash('error', 'Taille invalide ou stock épuisé.');
            return $this->redirectToRoute('product_detail', ['id' => $product->getId()]);
        }

        // Gestion du panier
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        // Identifier l'article dans le panier (ID et taille)
        $itemKey = $id . '-' . $size;

        // Ajouter ou mettre à jour la quantité dans le panier
        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['quantity'] += 1;
        } else {
            $cart[$itemKey] = [
                'id' => $product->getId(),
                'image' => $product->getImage(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'size' => $size,
                'quantity' => 1,
            ];
        }

        // Sauvegarder le panier dans la session
        $session->set('cart', $cart);

        $this->addFlash('success', 'Produit ajouté au panier avec succès.');
        return $this->redirectToRoute('cart'); // Redirection vers la page du panier
    }
    
    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart($id, Request $request): Response
    {
        // Gestion du panier depuis la session
        $session = $request->getSession();
        $cart = $session->get('cart', []); // Récupération du panier depuis la session
    
        // Vérifier si l'article (par sa clé) existe dans le panier
        if (isset($cart[$id])) {
            unset($cart[$id]); // Supprimer l'article
        }
    
        // Sauvegarder les modifications dans la session
        $session->set('cart', $cart);
    
        $this->addFlash('success', 'Produit retiré du panier avec succès.');
        return $this->redirectToRoute('cart'); // Redirige vers la page du panier
    } 
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(CartService $cartService, StripeService $stripeService): Response
    {
        $cart = $cartService->getFullCart();
        if (empty($cart)) {
            return $this->redirectToRoute('app_cart_show');
        }
    
        $cartItems = [];
        foreach ($cart as $item) {
            $cartItems[] = [
                'product' => $item['product'], // Produit en entier
                'quantity' => $item['quantity'], // Quantité spécifiée
            ];
        }
    
        $session = $stripeService->createCheckoutSession(
            $cartItems,
            $this->generateUrl('payment_success', [], true), // Génère une URL absolue
            $this->generateUrl('payment_cancel', [], true)  // Génère une URL absolue
        );
    
        // Redirige l'utilisateur vers l'URL de la session Stripe
        return $this->redirect($session->url, 303);
    }

    #[Route('/success', name: 'payment_success')]
    public function success(CartService $cartService): Response
    {
        $cartService->clear();
        $this->addFlash('success', 'Votre paiement a été effectué avec succès !');
        return $this->redirectToRoute('app_home');
    }

    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('error', 'Votre paiement a été annulé.');
        return $this->redirectToRoute('app_cart_show');
    }
}