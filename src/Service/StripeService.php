<?php

namespace App\Service;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


class StripeService 
{
    public function __construct(
        private string $stripeApiSecret,
    ) {
        Stripe::setApiKey($this->stripeApiSecret);
    }

    public function createCheckoutSession(
        array $cartItems,
        string $successUrl,
        string $cancelUrl
    ): StripeSession {
        $lineItems = []; // Tableau pour Stripe
    
        foreach ($cartItems as $cartItem) {
            // Validation des données du produit
            if (!isset($cartItem['product'], $cartItem['quantity'])) {
                throw new \InvalidArgumentException('Les informations du produit sont invalides');
            }
    
            $product = $cartItem['product']; // Produit
            $quantity = $cartItem['quantity']; // Quantité
    
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur', // La devise doit être spécifiée
                    'product_data' => [
                        'name' => $product->getName(), // Nom du produit
                    ],
                    'unit_amount' => $product->getPrice() * 100, // Convertir en centimes
                ],
                'quantity' => $quantity, // Quantité spécifiée
            ];
        }
    
        // Crée la session de paiement Stripe
        return StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    }
}