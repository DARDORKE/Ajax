<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $post = new Post();
        $post->setTitle('lfmazfaga')->setContent('faegzehzege');
        $manager->persist($post);

        $post2 = new Post();
        $post2->setTitle('gzegzfdqs')->setContent('fezgzgfsfdsccbx');
        $manager->persist($post2);

        $post3 = new Post();
        $post3->setTitle('vsdgzgze')->setContent('azfazZD AZAAZ ZAZDE    ZD ZZAR ZA');
        $manager->persist($post3);

        $manager->flush();
    }
}
