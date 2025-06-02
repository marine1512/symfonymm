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

/**
 * Contrôleur pour gérer les opérations CRUD sur les sweatshirts côté admin.
 *
 * @package App\Controller
 */
#[Route('/admin', name: 'admin_sweatshirt_')]
class SweatshirtController extends AbstractController
{
    /**
     * Affiche la liste de tous les sweatshirts.
     *
     * @param SweatshirtRepository $sweatshirtRepository Le repository pour accéder aux sweatshirts.
     *
     * @return Response La réponse HTTP rendant la liste des sweatshirts.
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
     * Crée un nouveau sweatshirt.
     *
     * @param Request                $request         La requête HTTP contenant les données du formulaire.
     * @param EntityManagerInterface $entityManager   Le gestionnaire d'entités pour manipuler la base de données.
     *
     * @return Response La réponse HTTP pour afficher le formulaire ou rediriger après la création.
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
     * Affiche un sweatshirt donné.
     *
     * @param Sweatshirt $sweatshirt Le sweatshirt à afficher.
     *
     * @return Response La réponse HTTP contenant le sweatshirt rendu.
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Sweatshirt $sweatshirt): Response
    {
        return $this->render('sweatshirt/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }

    /**
     * Édite un sweatshirt donné.
     *
     * @param Request                $request       La requête HTTP contenant les données modifiées.
     * @param Sweatshirt             $sweatshirt    Le sweatshirt à modifier.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités pour persister les modifications.
     *
     * @return Response La réponse HTTP pour afficher le formulaire ou rediriger après l'édition.
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
     * Supprime un sweatshirt donné.
     *
     * @param Request                $request       La requête HTTP contenant le token CSRF.
     * @param Sweatshirt             $sweatshirt    Le sweatshirt à supprimer.
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités pour effectuer la suppression.
     *
     * @return Response Une redirection vers la liste des sweatshirts après suppression.
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