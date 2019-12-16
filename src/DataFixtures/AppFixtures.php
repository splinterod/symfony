<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i <= 1000; $i++) {
            $slugify = new Slugify();

            $category = new Category();
            $category->setName($faker->word);
            $this->addReference('cat' . $i, $category);
            $manager->persist($category);

            $actor = new Actor();
            $slugify = new Slugify();
            $actor->setName($faker->name);
            $actor->setSlug($slugify->generate($actor->getName()));
            $this->setReference('actorX' . $i, $actor);
            $manager->persist($actor);
        }

        for ($i = 0; $i <= 1000; $i++) {


            $slugify = new Slugify();
            $program = new Program();
            $program->setTitle($faker->firstName . ' the ' . $faker->jobTitle);
            $program->setSlug($slugify->generate($program->getTitle()));
            $program->setPoster($faker->imageUrl());
            $program->setSummary($faker->text(100));
            $program->setCategory($this->getReference('cat'. random_int(0,10)));
            for($j=0;$j<=random_int(1,10);$j++) {
                $program->addActor($this->getReference('actorX' . $j));
            }
            $manager->persist($program);
        }
        $manager->flush();
    }
}
