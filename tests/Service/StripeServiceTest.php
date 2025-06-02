<?php

namespace App\Tests\Service;

use App\Service\StripeService;
use PHPUnit\Framework\TestCase;

class StripeServiceTest extends TestCase
{
    private StripeService $stripeService;

    protected function setUp(): void
    {
        $this->stripeService = new StripeService('***REMOVED***tdXcoroX0WZSnXmLOLJn3uTfEyRXxYELbZ3f5OcNUZ2E5y3FI304Qupc4z1GIPWp900Htq0nD74'); 
    }

    public function testCreateCheckoutSession(): void
    {
        // Simuler les données des produits du panier
        $cartItems = [
            [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => ['name' => 'Test Product'],
                    'unit_amount' => 10,
                ],
                'quantity' => 2,
            ],
        ];

        $successUrl = 'http://127.0.0.1:8000/success';
        $cancelUrl = 'http://127.0.0.1:8000/cancel';

        // Appeler réellement la méthode pour créer une session Checkout
        $result = $this->stripeService->createCheckoutSession($cartItems, $successUrl, $cancelUrl);

        // Assertions pour vérifier que la session a été créée avec succès
        $this->assertNotEmpty($result->id);
        $this->assertStringStartsWith('cs_', $result->id); // Vérifie que l'ID commence par 'cs_' (format des sessions Stripe)
    }
}