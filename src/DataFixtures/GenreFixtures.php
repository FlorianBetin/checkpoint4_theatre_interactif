<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class GenreFixtures extends Fixture
{
    public const GENRELIST = [

        [
            'name' => 'Comedie',
        ],
        [
            'name' => 'Tragedie',
        ],
    ];

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $genreIndex = 0;
    public function load(ObjectManager $manager): void
    {
        foreach (self::GENRELIST as $key => $genreInfo) {
            $genre = new Genre();
            $genre->setName($genreInfo['name']);
            $manager->persist($genre);
            $this->addReference('genre_' . $key, $genre);
            self::$genreIndex++;
        }

        $manager->flush();
    }
}