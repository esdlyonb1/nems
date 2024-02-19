<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Nem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create();

        for($i=0; $i<= 50; $i++) {
            $nem = new Nem();
            $nem->setName($faker->firstName);
            $nem->setPrice(rand(1, 18));
            $nem->setCreatedAt($faker->dateTimeBetween(startDate: "- 1 year", endDate: "now"));
            $manager->persist($nem);

            $random = rand(0, 10);

            for ($j = 0; $j <= $random; $j++) {
                $comment = new Comment();
                $comment->setContent($faker->sentence);
                $comment->setCreatedAt($faker->dateTimeBetween(startDate: $nem->getCreatedAt()));
                $comment->setNem($nem);
                $manager->persist($comment);

            }


        }




       // $manager->flush();
    }
}
