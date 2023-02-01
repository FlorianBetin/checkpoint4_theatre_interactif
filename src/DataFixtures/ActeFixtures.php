<?php

namespace App\DataFixtures;

use App\Entity\Acte;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $acteIndex = 0;
    public function load(ObjectManager $manager): void
    {
        for ($j = 0; $j < PieceFixtures::$pieceIndex; $j++) {
            for ($i = 0; $i < 3; $i++) {
                $acte = new Acte();
                $acte->setTitle('Acte' . ' ' . $i + 1);
                $acte->setSlug($this->slugger->slug($acte->getTitle()));
                $acte->setPiece($this->getReference('piece_' . $j));
                $manager->persist($acte);
                $this->addReference('acte_' . self::$acteIndex, $acte);
                self::$acteIndex++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PieceFixtures::class,
        ];
    }
}