<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Sentence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SentenceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public static int $sentenceIndex = 0;
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($j = 0; $j < ActeFixtures::$acteIndex; $j++) {
            for ($i = 0; $i < 20; $i++) {
                $sentence = new Sentence();
                // $sentence->setBackground();
                // $sentence->setCharacterOne();
                // $sentence->setCharacterTwo();
                // $sentence->setSpeaker();
                $sentence->setContent($faker->paragraphs(2, true));
                $sentence->setStep($i + 1);
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