<?php

namespace App\Controller;

use App\Entity\Acte;
use App\Form\ActeType;
use App\Repository\ActeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/acte')]
class ActeController extends AbstractController
{
    #[Route('/', name: 'app_acte_index', methods: ['GET'])]
    public function index(ActeRepository $acteRepository): Response
    {
        return $this->render('acte/index.html.twig', [
            'actes' => $acteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_acte_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActeRepository $acteRepository): Response
    {
        $acte = new Acte();
        $form = $this->createForm(ActeType::class, $acte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $acteRepository->save($acte, true);

            return $this->redirectToRoute('app_acte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('acte/new.html.twig', [
            'acte' => $acte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acte_show', methods: ['GET'])]
    public function show(Acte $acte): Response
    {
        return $this->render('acte/show.html.twig', [
            'acte' => $acte,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_acte_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Acte $acte, ActeRepository $acteRepository): Response
    {
        $form = $this->createForm(ActeType::class, $acte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $acteRepository->save($acte, true);

            return $this->redirectToRoute('app_acte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('acte/edit.html.twig', [
            'acte' => $acte,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_acte_delete', methods: ['POST'])]
    public function delete(Request $request, Acte $acte, ActeRepository $acteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$acte->getId(), $request->request->get('_token'))) {
            $acteRepository->remove($acte, true);
        }

        return $this->redirectToRoute('app_acte_index', [], Response::HTTP_SEE_OTHER);
    }
}
