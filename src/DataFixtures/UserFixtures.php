<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = Array();
        for ($i = 0; $i < 8; $i++) {
            $users[$i] = new User();
            $users[$i]->setEmail($faker->email);
            $users[$i]->setPassword($faker->password);
            $users[$i]->setRoles(["ROLE_USER"]);
            $manager->persist($users[$i]);
        }

        $posts = Array();
        for ($i = 0; $i < 20; $i++) {
            $posts[$i] = new Post();
            $posts[$i]->setTitle($faker->title);
            $posts[$i]->setContent($faker->text());
            $manager->persist($posts[$i]);
        }

        $manager->flush();
    }
}
