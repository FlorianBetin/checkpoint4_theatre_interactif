<?php

namespace App\Controller;

use App\Entity\Acte;
use App\Entity\Piece;
use App\Entity\Sentence;
use App\Repository\SentenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/piece')]
class PieceController extends AbstractController
{

    #[Route('/{slug}/', name: 'app_piece_show', methods: ['GET'])]
    public function showPiece(Piece $piece): Response
    {
        return $this->render('piece/show.html.twig', [
            'piece' => $piece,
        ]);
    }

    #[Route('/{piece_slug}/{acte_slug}/{sentence_step}', name: 'app_piece_play')]
    #[Entity('piece', options: ['mapping' => ['piece_slug' => 'slug']])]
    #[Entity('acte', options: ['mapping' => ['acte_slug' => 'slug']])]
    #[Entity('sentence', options: ['mapping' => ['sentence_step' => 'step']])]
    public function showScene(
        Piece $piece,
        Acte $acte,
        Sentence $sentence,
        SentenceRepository $sentenceRepository
    ): Response {

        
        $countStep = $sentenceRepository->countStep($acte);

        return $this->render('sentence/index.html.twig', [
            'piece' => $piece,
            'acte' => $acte,
            'sentence' => $sentence,
            'countstep' => $countStep[0][1]
        ]);
    }
}
