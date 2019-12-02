<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
        ],
        'The Haunting Of Hill House' => [
            'summary' => 'le hunting est pas pret de se faire avoir .',
            'category' => 'categorie_4',        ],
        'American Horror Story' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
        ],
        'Love Death And Robots' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
        ],
        'Penny Dreadful' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
        ],
        'Fear The Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setCategory($this->getReference($data['category']));
            $this->addReference('program' .$i , $program);
            $manager->persist($program);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()

    {

        return [CategoryFixtures::class];

    }
}