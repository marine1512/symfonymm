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
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Panier",
 *     description="Gestion du panier"
 * )
 */

class CartController extends AbstractController
{
    /**
     * Affiche le panier.
     * @OA\Get(
     *     path="/cart",
     *     summary="Afficher le contenu du panier",
     *     tags={"Panier"},
     *     @OA\Response(
     *         response=200,
     *         description="Page du panier affichée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="cart", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="totalPrice", type="number", format="float")
     *         )
     *     )
     * )
     */
    #[Route('/cart', name: 'cart', methods: ['GET'])]
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

     /**
     * Ajoute un produit au panier.
     *
     * @OA\Post(
     *     path="/cart/add/{id}",
     *     summary="Ajouter un produit au panier",
     *     tags={"Panier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit à ajouter au panier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Données pour ajouter le produit au panier",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="size", type="string", description="Taille du produit sélectionnée")
     *         )
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirection vers le panier après ajout"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */
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
        return $this->redirectToRoute('cart'); 
    }
    
    /**
     * Supprime un produit du panier.
     *
     * @OA\Post(
     *     path="/cart/remove/{id}",
     *     summary="Supprimer un produit du panier",
     *     tags={"Panier"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID unique du produit à supprimer du panier",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=302,
     *         description="Redirection vers le panier après suppression"
     *     )
     * )
     */
    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart($id, Request $request): Response
    {
        // Gestion du panier depuis la session
        $session = $request->getSession();
        $cart = $session->get('cart', []); 
    
        // Vérifier si l'article (par sa clé) existe dans le panier
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
    
        // Sauvegarder les modifications dans la session
        $session->set('cart', $cart);
    
        $this->addFlash('success', 'Produit retiré du panier avec succès.');
        return $this->redirectToRoute('cart'); 
    } 

    /**
     * Crée une session de paiement Stripe.
     *
     *
     * @OA\Post(
     *     path="/checkout",
     *     summary="Créer une session Stripe pour le panier actuel",
     *     tags={"Paiement"},
     *     @OA\Response(
     *         response=303,
     *         description="Redirige vers l'URL de paiement Stripe Checkout"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Retourne une erreur si le panier est vide",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Votre panier est vide.")
     *         )
     *     )
     * )
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
                    'unit_amount' => (int) ($item['product']->getPrice() * 100),  // Prix en centimes
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
     * Confirmation de paiement réussi.
     *
     *
     * @OA\Get(
     *     path="/success",
     *     summary="Confirme que le paiement a été effectué avec succès",
     *     tags={"Paiement"},
     *     @OA\Response(
     *         response=200,
     *         description="Retourne un message confirmant le succès du paiement"
     *     )
     * )
     */
    #[Route('/success', name: 'payment_success')]
    public function success(CartService $cartService): Response
    {
        $cartService->clear();
        $this->addFlash('success', 'Votre paiement a été effectué avec succès !');
        return $this->redirectToRoute('home');
    }

    /**
     * Annulation d'un paiement.
     *
     *
     * @OA\Get(
     *     path="/cancel",
     *     summary="Indique que le paiement a été annulé",
     *     tags={"Paiement"},
     *     @OA\Response(
     *         response=200,
     *         description="Retourne un message signalant l'annulation du paiement"
     *     )
     * )
     */
    #[Route('/cancel', name: 'payment_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('error', 'Votre paiement a été annulé.');
        return $this->redirectToRoute('cart');
    }
}