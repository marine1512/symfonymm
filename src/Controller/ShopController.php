<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(name="Boutique", description="Gestion des produits de la boutique")
 */
 
class ShopController extends AbstractController
{
    /**
     * Lister les produits avec un filtrage facultatif par plage de prix.
     * 
     *
     * @OA\Get(
     *     path="/products",
     *     summary="Lister les produits",
     *     tags={"Boutique"},
     *     @OA\Parameter(
     *         name="priceRange",
     *         in="query",
     *         description="Filtrer par plage de prix. Exemples : '10-29', '29-35', '35-50'",
     *         required=false,
     *         @OA\Schema(type="string", example="10-29")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Une liste des produits disponibles",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Sweatshirt rouge"),
     *                 @OA\Property(property="price", type="number", format="float", example=29.99),
     *                 @OA\Property(property="image", type="string", example="/images/sweat.png")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Paramètre de requête non valide"
     *     )
     * )
     */
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

    /**
     * Détails d’un produit spécifique.
     *
     * @OA\Get(
     *     path="/product/{id}",
     *     summary="Détails d'un produit",
     *     tags={"Boutique"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Identifiant du produit",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails d'un produit",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Sweatshirt rouge"),
     *             @OA\Property(property="description", type="string", example="Un sweatshirt chaud et confortable."),
     *             @OA\Property(property="price", type="number", format="float", example=29.99),
     *             @OA\Property(property="stock", type="integer", example=15),
     *             @OA\Property(property="image", type="string", example="/images/sweatred.png")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé."
     *     )
     * )
     */
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