<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{

    const Actors = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
    ];
    public function load(ObjectManager $manager)
    {
        $i=0;
        $this->loadData($manager);
        foreach (self::Actors as $key => $actorName) {
            $slug =  new slugify();
            $actor = new Actor();
            $actor->setName($actorName);
            $this->addReference('actor' . $i, $actor);
            $actor->setSlug($slug->generate($actor->getName()));
            $i++;
            $actor->addProgram($this->getReference('program'. random_int(0,5)));
            $manager->persist($actor);        }
        $manager->flush();
    }

    public function loadData(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i=5;$i<55;$i++) {
            $slug =  new slugify();
            $actor = new actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program' . random_int(0,5)));
            $actor->setSlug($slug->generate($actor->getName()));
            $this->addReference('actor' . $i, $actor);

            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()

    {

        return [ProgramFixtures::class];

    }
}
