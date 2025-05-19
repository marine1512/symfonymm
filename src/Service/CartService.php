<?php

namespace App\Service;

use App\Repository\SweatshirtRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService 
{
    public function __construct(
        private RequestStack $requestStack,
        private SweatshirtRepository $sweatshirtRepository,
    ) {}

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function add(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        $this->getSession()->set('cart', $cart);
    }

    public function getFullCart(): array
    {
        $cart = $this->getSession()->get('cart', []);
        $fullCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->sweatshirtRepository->find($id);
            if ($product) {
                $fullCart[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }
        return $fullCart;
    }

    public function clear(): void
    {
        $this->getSession()->remove('cart');
    }

    public function remove(int $id): void
    {
        $cart = $this->getSession()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->getSession()->set('cart', $cart);
        }
    }
}
