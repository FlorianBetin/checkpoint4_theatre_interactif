<?php

namespace App\Component;

use App\Entity\Piece;
use App\Form\PieceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent('piece_form')]
class PieceForm extends AbstractController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(fieldName: 'pieceField', dehydrateWith: 'dehydrateWith')]
    public ?Piece $piece = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PieceType::class, $this->piece);
    }

    public function dehydrateWith(): void
    {
    }

    #[LiveAction]
    public function addActe(): void
    {
        $this->formValues['actes'][] = '';
    }

    #[LiveAction]
    public function removeQuestion(#[LiveArg()] int $index): void
    {
        unset($this->formValues['actes'][$index]);
    }

    // #[LiveAction]
    // public function addAnswer(#[LiveArg()] int $questionIndex): void
    // {
    //     $this->formValues['questions'][$questionIndex]['answers'][] = '';
    // }

    // #[LiveAction]
    // public function removeAnswer(#[LiveArg()] int $questionIndex, #[LiveArg()] int $answerIndex): void
    // {
    //     unset($this->formValues['questions'][$questionIndex]['answers'][$answerIndex]);
    // }
}