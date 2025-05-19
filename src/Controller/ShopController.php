<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;
 
class ShopController extends AbstractController
{
    #[Route('/products', name: 'shop')]
    public function list(Request $request, SweatshirtRepository $productRepository): Response
    {
        // Filtrage par plage de prix
        $priceRange = $request->query->get('priceRange', '');
        $minPrice = 0;
        $maxPrice = PHP_INT_MAX;
    
        if ($priceRange === '10-29') {
            $minPrice = 10;
            $maxPrice = 29;
        } elseif ($priceRange === '29-35') {
            $minPrice = 29;
            $maxPrice = 35;
        } elseif ($priceRange === '35-50') {
            $minPrice = 35;
            $maxPrice = 50;
        }
    
        // Récupérer les produits filtrés
        $products = $productRepository->findByPriceRange($minPrice, $maxPrice);
    
        return $this->render('shop/index.html.twig', [
            'products' => $products,
            'priceRange' => $priceRange,
        ]);
    }

    #[Route('/product/{id}', name: 'product_detail')]
    public function detail(int $id, SweatshirtRepository $productRepository): Response
    {
    $product = $productRepository->find($id);

    if (!$product) {
        throw $this->createNotFoundException('Produit non trouvé');
    }

    return $this->render('shop/detail.html.twig', [
        'product' => $product,
    ]);
    }
}