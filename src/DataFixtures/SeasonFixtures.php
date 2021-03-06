<?php


namespace App\DataFixtures;

use App\Entity\Season;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use  Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker  =  Faker\Factory::create('fr_FR');

        for ($i=0;$i<50;$i++) {
            $slug= new Slugify();
            $season = new season();
            $season->setYear($faker->year);
            $season->setDescription($faker->text(250));
            $season->setProgram($this->getReference('program' . random_int(0,5)));
            $season->setSlug($slug->generate($season->getYear()));
            $this->addReference('season' . $i, $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies()

    {

        return [ProgramFixtures::class];

    }
}

