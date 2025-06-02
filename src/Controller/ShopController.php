<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;

/**
 * Contrôleur pour gérer la boutique en ligne.
 *
 * Ce contrôleur gère la liste des produits et les détails d'un produit individuel.
 */
class ShopController extends AbstractController
{
    /**
     * Affiche la liste des produits disponibles dans la boutique.
     *
     * Cette méthode applique un filtrage facultatif basé sur une plage de prix
     * indiquée dans les requêtes. 
     *
     * @Route("/products", name="shop", methods={"GET"})
     *
     * @param Request $request La requête HTTP contenant les données du filtre de prix.
     * @param SweatshirtRepository $productRepository Le repository permettant de récupérer les produits.
     *
     * @return Response La réponse HTTP contenant la vue avec la liste des produits.
     */
    #[Route('/products', name: 'shop', methods: ['GET'])]
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

    /**
     * Affiche les détails d'un produit spécifique.
     *
     * Si le produit n'est pas trouvé, une exception HTTP 404 est levée.
     *
     * @Route("/product/{id}", name="product_detail", methods={"GET"})
     *
     * @param int $id L'identifiant unique du produit à afficher.
     * @param SweatshirtRepository $productRepository Le repository permettant de trouver les produits.
     *
     * @return Response La réponse HTTP contenant la vue des détails du produit.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException Si le produit n'est pas trouvé.
     */
    #[Route('/product/{id}', name: 'product_detail', methods: ['GET'])]
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