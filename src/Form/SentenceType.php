<?php

namespace App\Form;

use App\Entity\Sentence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SentenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('background')
            ->add('character_one')
            // ->add('character_two')
            ->add('content')
            // ->add('step')
            // ->add('acte')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sentence::class,
        ]);
    }
}
