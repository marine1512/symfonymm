<?php

namespace App\Controller;

use App\Repository\SweatshirtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Accueil",
 *     description="Endpoints pour gérer la page d'accueil"
 * )
 */

// Ce contrôleur gère toutes les responsabilités de la page d'accueil
final class AccueilController extends AbstractController
{
    /**
     * 
     * @OA\Get(
     *     path="/",
     *     summary="Récupère la page d'accueil",
     *     description="Affiche la page d'accueil avec les produits mis en avant.",
     *     tags={"Accueil"},
     *     @OA\Response(
     *         response=200,
     *         description="Page d'accueil affichée avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="promotedProducts",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="T-shirt promo"),
     *                     @OA\Property(property="price", type="number", format="float", example=29.99),
     *                     @OA\Property(property="image", type="string", example="https://example.com/tshirt.jpg")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="isUserLoggedIn",
     *                 type="boolean",
     *                 example=true
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé. L'utilisateur doit être connecté.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Vous devez être connecté.")
     *         )
     *     )
     * )
     */
    #[Route('/', name: 'app_accueil', methods: ['GET'])]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        // Récupérer les produits promus
        $promotedProducts = $sweatshirtRepository->findPromotedSweatshirts();

        // Vérifier si l'utilisateur est connecté
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('accueil/index.html.twig', [
            'promotedProducts' => $promotedProducts,
            'isUserLoggedIn' => $isUserLoggedIn,
        ]);
    }
}