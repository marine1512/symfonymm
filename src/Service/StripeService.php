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
        $lineItems = [];
    
        foreach ($cartItems as $cartItem) {
            if (!isset($cartItem['price_data'], $cartItem['quantity'])) {
                throw new \InvalidArgumentException('Les informations du produit sont invalides');
            }
    
            $priceData = $cartItem['price_data'];
            $lineItems[] = [
                'price_data' => [
                    'currency' => $priceData['currency'],
                    'product_data' => [
                        'name' => $priceData['product_data']['name'], 
                    ],
                    'unit_amount' => (int) $priceData['unit_amount'],
                ],
                'quantity' => (int) $cartItem['quantity'], 
            ];
        }
    
        // Crée une session Stripe
        return StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    }
}