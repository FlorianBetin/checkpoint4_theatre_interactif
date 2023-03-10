<?php

namespace App\Controller\Admin;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/genre')]
class AdminGenreController extends AbstractController
{
    #[Route('/', name: 'admin_app_genre_index', methods: ['GET'])]
    public function index(GenreRepository $genreRepository): Response
    {
        return $this->render('Admin/genre/index.html.twig', [
            'genres' => $genreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_app_genre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GenreRepository $genreRepository): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre->setSlug($genre->getName());
            $genreRepository->save($genre, true);

            return $this->redirectToRoute('admin_app_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/genre/new.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_genre_show', methods: ['GET'])]
    public function show(Genre $genre): Response
    {
        return $this->render('Admin/genre/show.html.twig', [
            'genre' => $genre,
        ]);
    }
    

    #[Route('/{id}/edit', name: 'admin_app_genre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Genre $genre, GenreRepository $genreRepository): Response
    {
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genreRepository->save($genre, true);

            return $this->redirectToRoute('admin_app_genre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Admin/genre/edit.html.twig', [
            'genre' => $genre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_app_genre_delete', methods: ['POST'])]
    public function delete(Request $request, Genre $genre, GenreRepository $genreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genre->getId(), $request->request->get('_token'))) {
            $genreRepository->remove($genre, true);
        }

        return $this->redirectToRoute('admin_app_genre_index', [], Response::HTTP_SEE_OTHER);
    }
}
