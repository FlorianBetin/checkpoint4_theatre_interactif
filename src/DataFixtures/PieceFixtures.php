<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Piece;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PieceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $pieceIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < GenreFixtures::$genreIndex; $j++) {
            for ($i = 0; $i < 4; $i++) {
                $piece = new Piece();
                $piece->setTitle($faker->title() . ' ' . $j . $i);
                $piece->setDescription($faker->paragraphs(1, true));
                // $piece->setImage();
                $piece->setSlug($this->slugger->slug($piece->getTitle()));
                $piece->setGenre($this->getReference('genre_' . $j));
                $manager->persist($piece);
                $this->addReference('piece_' . self::$pieceIndex, $piece);
                self::$pieceIndex++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
        ];
    }
}