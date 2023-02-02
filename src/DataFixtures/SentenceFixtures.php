<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Sentence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class SentenceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger, private readonly ContainerBagInterface $containerBag, private readonly DecoderInterface $decoder)
    {
    }

    public static int $sentenceIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $file = 'scene_content.csv';
        $filePath = __DIR__ . '/data/' . $file;
        $context = [
            CsvEncoder::DELIMITER_KEY => ',',
            CsvEncoder::ENCLOSURE_KEY => '"',
            CsvEncoder::ESCAPE_CHAR_KEY => '\\',
            CsvEncoder::KEY_SEPARATOR_KEY => ',',
        ];
        $csv = $this->decoder->decode(file_get_contents($filePath), 'csv', $context);
        for ($j = 0; $j < ActeFixtures::$acteIndex; $j++) {
            foreach ($csv as $key => $sentenceDetail) {
                $sentence = new Sentence();
                $file = __DIR__ . '/data/scene_content/' . $sentenceDetail['background'];
                if (
                    copy($file, $this->containerBag->get('upload_directory') .
                        'images/scene_content/' . $sentenceDetail['background'])
                ) {
                    $sentence->setBackground($sentenceDetail['background']);
                }
                $file = __DIR__ . '/data/scene_content/' . $sentenceDetail['background'];
                if (
                    copy($file, $this->containerBag->get('upload_directory') .
                        'images/scene_content/' . $sentenceDetail['character_one'])
                ) {
                    $sentence->setCharacterOne($sentenceDetail['character_one']);
                }
                // $sentence->setCharacterOne();
                // $sentence->setCharacterTwo();
                // $sentence->setSpeaker();
                $sentence->setContent($faker->paragraphs(2, true));
                $sentence->setStep($key + 1);
                $sentence->setActe($this->getReference('acte_' . $j));
                $manager->persist($sentence);
                $this->addReference('sentence_' . self::$sentenceIndex, $sentence);
                self::$sentenceIndex++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ActeFixtures::class,
        ];
    }
}