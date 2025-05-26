<?php

namespace App\Controller;

use App\Entity\Sweatshirt;
use App\Form\SweatshirtForm;
use App\Form\SweatShirtType;
use App\Repository\SweatshirtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_sweatshirt_')]
class SweatshirtController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SweatshirtRepository $sweatshirtRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('sweatshirt/index.html.twig', [
            'sweatshirts' => $sweatshirtRepository->findAll(),
        ]);
    }

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

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Sweatshirt $sweatshirt): Response
    {
        return $this->render('sweatshirt/show.html.twig', [
            'sweatshirt' => $sweatshirt,
        ]);
    }
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