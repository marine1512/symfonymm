<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Service\CartService; // Utilisation de CartService
use App\Entity\Sweatshirt;    // Utilisation de la classe Sweatshirt

class CartTest extends TestCase
{
    public function testAddItem(): void
    {
        // Créer le service de panier
        $cartService = new CartService();

        // Créer un produit
        $sweatshirt = new Sweatshirt(1, 'Sweatshirt', 30);

        // Ajouter le produit au panier
        $cartService->addItem($sweatshirt, 2);

        // Vérifier que le produit est bien ajouté
        $this->assertNotEmpty($cartService->getItems());
        $this->assertEquals(2, $cartService->getItems()[$sweatshirt->getId()]['quantity']);
    }

    public function testRemoveItem(): void
    {
        // Créer le service de panier
        $cartService = new CartService();

        // Ajouter un produit
        $sweatshirt = new Sweatshirt(1, 'Sweatshirt', 30);
        $cartService->addItem($sweatshirt, 2);

        // Supprimer le produit
        $cartService->removeItem($sweatshirt->getId());

        // Vérifier que le produit a bien été supprimé
        $this->assertEmpty($cartService->getItems());
    }

    public function testCalculateTotal(): void
    {
        // Créer le service de panier
        $cartService = new CartService();

        // Ajouter plusieurs produits
        $sweatshirt1 = new Sweatshirt(1, 'Sweatshirt A', 30.0);
        $sweatshirt2 = new Sweatshirt(2, 'Sweatshirt B', 20.0);

        $cartService->addItem($sweatshirt1, 2); // 2 x 30 = 60
        $cartService->addItem($sweatshirt2, 1); // 1 x 20 = 20

        // Vérifier le total calculé
        $this->assertEquals(80.0, $cartService->getTotal());
    }
}