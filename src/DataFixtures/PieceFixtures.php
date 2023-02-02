<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Piece;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class PieceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger, private readonly ContainerBagInterface $containerBag, private readonly DecoderInterface $decoder)
    {
    }

    public static int $pieceIndex = 0;


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $file = 'piece.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $context = [
            CsvEncoder::DELIMITER_KEY => ',',
            CsvEncoder::ENCLOSURE_KEY => '"',
            CsvEncoder::ESCAPE_CHAR_KEY => '\\',
            CsvEncoder::KEY_SEPARATOR_KEY => ',',
        ];
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv', $context);
        foreach ($csv as $pieceDetail) {
            $piece = new Piece();
            $piece->setTitle($pieceDetail['title']);
            $piece->setDescription($faker->paragraphs(1, true));
            $piece->setSlug($this->slugger->slug($piece->getTitle()));
            $piece->setGenre($this->getReference('genre_' . $pieceDetail['genre_id']));
            $file = __DIR__ . '/data/piececover/' . $pieceDetail['image'];
            if (
                copy($file, $this->containerBag->get('upload_directory') .
                    'images/piececover/' . $pieceDetail['image'])
            ) {
                $piece->setImage($pieceDetail['image']);
            }
            $this->addReference('piece_' . self::$pieceIndex, $piece);
            self::$pieceIndex++;
            $manager->persist($piece);
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