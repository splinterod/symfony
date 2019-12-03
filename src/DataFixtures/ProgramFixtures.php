<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BZmFlMTA0MmUtNWVmOC00ZmE1LWFmMDYtZTJhYjJhNGVjYTU5XkEyXkFqcGdeQXVyMTAzMDM4MjM0._V1_.jpg'
        ],
        'The Haunting Of Hill House' => [
            'summary' => 'le hunting est pas pret de se faire avoir .',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTU4NzA4MDEwNF5BMl5BanBnXkFtZTgwMTQxODYzNjM@._V1_SY1000_CR0,0,674,1000_AL_.jpg'],
        'American Horror Story' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BODZlYzc2ODYtYmQyZS00ZTM4LTk4ZDQtMTMyZDdhMDgzZTU0XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg'
        ],
        'Love Death And Robots' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BMTc1MjIyNDI3Nl5BMl5BanBnXkFtZTgwMjQ1OTI0NzM@._V1_SY1000_CR0,0,674,1000_AL_.jpg'
        ],
        'Penny Dreadful' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BNmE5MDE0ZmMtY2I5Mi00Y2RjLWJlYjMtODkxODQ5OWY1ODdkXkEyXkFqcGdeQXVyNjU2NjA5NjM@._V1_SY1000_CR0,0,695,1000_AL_.jpg'
        ],
        'Fear The Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma.',
            'category' => 'categorie_4',
            'poster' => 'https://m.media-amazon.com/images/M/MV5BYWNmY2Y1NTgtYTExMS00NGUxLWIxYWQtMjU4MjNkZjZlZjQ3XkEyXkFqcGdeQXVyMzQ2MDI5NjU@._V1_SY1000_CR0,0,666,1000_AL_.jpg'
        ]
    ];

    public function load(ObjectManager $manager)
    {
        $i=0;
        foreach (self::PROGRAMS as $title => $data) {
            $slugify = new Slugify();
            $program = new program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setPoster($data['poster']);
            $program->setSlug($slugify->generate($program->getTitle()));
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