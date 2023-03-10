<?php

namespace App\Controller\Admin;

use App\Entity\Piece;
use App\Form\PieceType;
use App\Repository\PieceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/piece')]
class AdminPieceController extends AbstractController
{
    #[Route('/', name: 'admin_app_piece_index', methods: ['GET'])]
    public function index(PieceRepository $pieceRepository): Response
    {
        return $this->render('Admin/piece/index.html.twig', [
            'pieces' => $pieceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_app_piece_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PieceRepository $pieceRepository): Response
    {
        $piece = new Piece();
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $piece->setSlug($piece->getTitle());
            $pieceRepository->save($piece, true);

            return $this->redirectToRoute('admin_app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/piece/new.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_piece_show', methods: ['GET'])]
    public function show(Piece $piece): Response
    {
        return $this->render('Admin/piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_app_piece_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piece $piece, PieceRepository $pieceRepository): Response
    {
        $form = $this->createForm(PieceType::class, $piece);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pieceRepository->save($piece, true);

            return $this->redirectToRoute('admin_app_piece_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/piece/edit.html.twig', [
            'piece' => $piece,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_piece_delete', methods: ['POST'])]
    public function delete(Request $request, Piece $piece, PieceRepository $pieceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$piece->getId(), $request->request->get('_token'))) {
            $pieceRepository->remove($piece, true);
        }

        return $this->redirectToRoute('admin_app_piece_index', [], Response::HTTP_SEE_OTHER);
    }
}