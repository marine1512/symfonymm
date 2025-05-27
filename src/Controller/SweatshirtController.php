<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Form\SweatshirtForm;
use App\Repository\SweatshirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Produits", description="Endpoints pour gérer les sweatshirts")
 */

#[Route('/admin', name: 'admin_sweatshirt_')]
class SweatshirtController extends AbstractController
{

    /**
     * Liste tous les sweatshirts.
     * 
     * @OA\Get(
     *     path="/admin/",
     *     summary="Liste les sweatshirts disponibles",
     *     tags={"Produits"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des sweatshirts.",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Sweatshirt")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Accès interdit (non admin)."
     *     )
     * )
     */
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('sweatshirt/index.html.twig', [
            'sweatshirts' => $sweatshirtRepository->findAll(),
        ]);
    }

    /**
     * Ajout d'un nouveau sweatshirt.
     * 
     * @OA\Post(
     *     path="/admin/new",
     *     summary="Créer un nouveau sweatshirt",
     *     tags={"Produits"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sweatshirt")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sweatshirt créé avec succès."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requête invalide."
     *     )
     * )
     */
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sweatShirt = new SweatShirt();
        $form = $this->createForm(SweatshirtForm::class, $sweatShirt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sweatShirt);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sweatshirt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sweatshirt/new.html.twig', [
            'sweat_shirt' => $sweatShirt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Afficher un sweatshirt spécifique.
     * 
     * @OA\Get(
     *     path="/admin/{id}",
     *     summary="Afficher un sweatshirt",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Identifiant unique du sweatshirt",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du sweatshirt.",
     *         @OA\JsonContent(ref="#/components/schemas/Sweatshirt")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sweatshirt non trouvé."
     *     )
     * )
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Sweatshirt $sweatshirt): Response
    {
        return $this->render('sweatshirt/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }

    /**
     * Modifier un sweatshirt.
     * 
     * @OA\Put(
     *     path="/admin/{id}/edit",
     *     summary="Modifier un sweatshirt",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Identifiant unique du sweatshirt",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sweatshirt")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sweatshirt modifié avec succès."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requête invalide."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sweatshirt non trouvé."
     *     )
     * )
     */
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sweatshirt $sweatshirt, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SweatshirtForm::class, $sweatshirt);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('admin_sweatshirt_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('sweatshirt/edit.html.twig', [
            'form' => $form->createView(),
            'sweatshirt' => $sweatshirt, 
        ]);
    }

    /**
     * Supprimer un sweatshirt.
     * 
     * @OA\Delete(
     *     path="/admin/{id}",
     *     summary="Supprimer un sweatshirt",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Identifiant unique du sweatshirt",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sweatshirt supprimé avec succès."
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Non autorisé."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sweatshirt non trouvé."
     *     )
     * )
     */
    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Sweatshirt $sweatshirt, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sweatshirt->getId(), $request->request->get('_token'))) {
            $entityManager->remove($sweatshirt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_sweatshirt_index', [], Response::HTTP_SEE_OTHER);
    }

}