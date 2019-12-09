<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i=0;$i<500;$i++) {
            $slug = new Slugify();
            $episode = new episode();
            $episode->setTitle($faker->jobTitle());
            $episode->setNumber($faker->randomDigit);
            $episode->setSynopsis($faker->text(250));
            $episode->setSeason($this->getReference('season' . random_int(0,49)));
            $episode->setSlug($slug->generate($episode->getTitle() . $i));

            $this->addReference('episode' . $i, $episode);
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()

    {

        return [SeasonFixtures::class];

    }
}