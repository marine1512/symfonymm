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
        dump($cartItems);

        foreach ($cartItems as $cartItem) {
            dd($cartItem);
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $cartItem['product']->getName(),
                    ],
                    'unit_amount' => $cartItem['product']->getPrice(),
                ],
                'quantity' => $cartItem['quantity'],
            ];
        }
        dd($successUrl, $cancelUrl);

        return StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    }
}
