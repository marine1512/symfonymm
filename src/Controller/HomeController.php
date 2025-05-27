<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SweatshirtRepository;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Accueil",
 *     description="Endpoints pour gérer la page d'accueil"
 * )
 */

class HomeController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/home",
     *     summary="Page d'accueil",
     *     tags={"Accueil"},
     *     description="Récupère les produits promus et l'état de connexion de l'utilisateur.",
     *     @OA\Response(
     *         response=200,
     *         description="Retourne la liste des produits promus et l'état de connexion.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="promotedProducts",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Sweatshirt")
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
     *         description="Utilisateur non authentifié"
     *     )
     * )
     * 
     * @OA\Schema(
     *     schema="Sweatshirt",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         example=1
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Sweatshirt Cool"
     *     ),
     *     @OA\Property(
     *         property="price",
     *         type="number",
     *         format="float",
     *         example=29.99
     *     ),
     *     @OA\Property(
     *         property="isPromoted",
     *         type="boolean",
     *         example=true
     *     )
     * )
     */
    #[Route('/home', name: 'home')]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        // Récupération des produits promus
        $promotedProducts = $sweatshirtRepository->findPromotedSweatshirts();

        // Vérification si l'utilisateur est connecté
        $isUserLoggedIn = $this->isGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('home/index.html.twig', [
            'promotedProducts' => $promotedProducts,
            'isUserLoggedIn' => $isUserLoggedIn,
        ]);
    }

}