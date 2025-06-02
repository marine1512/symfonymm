<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\SweatshirtRepository;
use App\Service\CartService;

class CartServiceTest extends KernelTestCase
{
    private CartService $cartService;
    private SessionInterface $session;
    private SweatshirtRepository $sweatshirtRepository;

    protected function setUp(): void
    {
        // Démarrage du kernel Symfony pour accéder aux services
        self::bootKernel();
    
        // Récupérer les services nécessaires
        $container = static::getContainer();
        $requestStack = $container->get(RequestStack::class);
        $this->sweatshirtRepository = $container->get(SweatshirtRepository::class);
    
        // Créer une session mockée associée à une requête
        $sessionMock = new \Symfony\Component\HttpFoundation\Session\Session(
            new \Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage()
        );
    
        $request = new \Symfony\Component\HttpFoundation\Request();
        $request->setSession($sessionMock);
    
        // Ajouter la requête au RequestStack
        $requestStack->push($request);
    
        // Sauvegarder la session pour l'utiliser dans les tests
        $this->session = $sessionMock;
    
        // Création du service à tester
        $this->cartService = new CartService($requestStack, $this->sweatshirtRepository);
    }

    public function testAddToCart(): void
    {
        // Ajout d'un produit au panier avec un ID fictif
        $this->cartService->add(1);
    
        // Vérifiez que le produit a été correctement ajouté
        $cart = $this->session->get('cart'); // Utilisation de `session`
        $this->assertArrayHasKey(1, $cart);
        $this->assertEquals(1, $cart[1]);
    
        // Ajouter une deuxième fois le même produit
        $this->cartService->add(1);
        $cart = $this->session->get('cart');
        $this->assertEquals(2, $cart[1]);
    }

    public function testRemoveFromCart(): void
    {
        // Ajoute un produit au panier
        $this->cartService->add(1);
        $cart = $this->session->get('cart'); // Utilisation de `session`
        $this->assertArrayHasKey(1, $cart);
    
        // Retirer le produit
        $this->cartService->remove(1);
    
        // Vérifiez que le produit a été retiré
        $cart = $this->session->get('cart');
        $this->assertArrayNotHasKey(1, $cart);
    }

    public function testGetFullCart(): void
    {
        // Ajout d'un produit existant (assurez-vous que l'ID 1 existe dans la base de données de test)
        $this->cartService->add(1);
        $cart = $this->cartService->getFullCart();

        // Vérifiez que la structure contient les bonnes informations
        $this->assertCount(1, $cart);
        $this->assertEquals(1, $cart[0]['quantity']);
        $this->assertNotNull($cart[0]['product']); // Produit doit exister

        // Ajout d'un autre produit
        $this->cartService->add(2); // ID 2 doit aussi exister
        $cart = $this->cartService->getFullCart();

        $this->assertCount(2, $cart); // On a maintenant deux produits
    }

    public function testClearCart(): void
    {
        // Ajout de produits au panier
        $this->cartService->add(1);
        $this->cartService->add(2);
    
        // Vider le panier
        $this->cartService->clear();
    
        // Vérifiez que le panier est vide
        $cart = $this->session->get('cart');
        $this->assertEmpty($cart);
    }
}