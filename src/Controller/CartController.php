<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Service\CartService;
use App\Service\StripeService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour la gestion du panier et du processus d'achat.
 */
class CartController extends AbstractController
{
    /**
     * Affiche le contenu du panier avec le prix total.
     *
     * @param Request $request La requête HTTP pour récupérer la session utilisateur.
     *
     * @return Response La réponse HTTP contenant la vue du panier.
     */
    #[Route('/cart', name: 'cart', methods: ['GET'])]
    public function index(Request $request): Response
    {
        // Récupération du panier en session
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

    /**
     * Ajoute un produit au panier.
     *
     * @param int $id L'identifiant du produit à ajouter.
     * @param Request $request La requête HTTP pour récupérer les données utilisateur.
     * @param ManagerRegistry $doctrine Gestionnaire des entités Doctrine.
     *
     * @return Response Une redirection vers la page du panier ou un autre endpoint adapté.
     *
     * @throws \LogicException Si le produit ou la taille est invalide.
     */
    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart($id, Request $request, ManagerRegistry $doctrine): Response
    {
        // Récupérer le produit depuis la base de données via Doctrine
        $product = $doctrine->getRepository(Sweatshirt::class)->find($id);

        if (!$product) {
            $this->addFlash('error', 'Produit non trouvé.');
            return $this->redirectToRoute('product_list');
        }

        // Récupération de la taille sélectionnée
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

        $itemKey = $id . '-' . $size;

        // Ajouter ou mettre à jour la quantité
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

        $session->set('cart', $cart);

        $this->addFlash('success', 'Produit ajouté au panier avec succès.');
        return $this->redirectToRoute('cart');
    }

    /**
     * Supprime un produit du panier.
     *
     * @param string $id La clé de l'article à supprimer (inclut taille et ID).
     * @param Request $request La requête HTTP contenant la session utilisateur.
     *
     * @return Response Une redirection vers la page du panier après mise à jour.
     */
    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart($id, Request $request): Response
    {
        $session = $request->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
        $this->addFlash('success', 'Produit retiré du panier avec succès.');

        return $this->redirectToRoute('cart');
    }

    /**
     * Lance le processus de paiement via Stripe.
     *
     * @param CartService $cartService Service de gestion du panier complet.
     * @param StripeService $stripeService Service pour la gestion des paiements via Stripe.
     *
     * @return Response Une redirection vers l'URL de paiement Stripe.
     *
     * @throws \Exception Si une erreur survient lors de la création de la session Stripe.
     */
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(CartService $cartService, StripeService $stripeService): Response
    {
        $cart = $cartService->getFullCart();
        if (empty($cart)) {
            return $this->redirectToRoute('cart');
        }

        foreach ($cart as $item) {
            $cartItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['product']->getName(),
                    ],
                    'unit_amount' => (int) ($item['product']->getPrice() * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = $stripeService->createCheckoutSession(
            $cartItems,
            $this->generateUrl('payment_success', [], false),
            $this->generateUrl('payment_cancel', [], false)
        );

        return $this->redirect($session->url, 303);
    }

    /**
     * Page de succès après paiement.
     *
     * @param CartService $cartService Service pour vider le panier après paiement.
     *
     * @return Response Redirection vers la page d'accueil.
     */
    #[Route('/success', name: 'payment_success')]
    public function success(CartService $cartService): Response
    {
        $cartService->clear();
        $this->addFlash('success', 'Votre paiement a été effectué avec succès !');
        return $this->render('cart/success.html.twig', [
            'message' => 'Merci pour votre achat ! Votre paiement a été effectué avec succès.',
        ]);
    }

    /**
     * Page affichée en cas d'annulation du paiement.
     *
     * @return Response Redirection vers la page du panier.
     */
    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('error', 'Votre paiement a été annulé.');
        return $this->redirectToRoute('cart');
    }
}
