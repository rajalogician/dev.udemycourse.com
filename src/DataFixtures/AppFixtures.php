<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blogPost = new BlogPost();
        $blogPost->setTitle('test post first')
            ->setAuthor('t ahmed')
            ->setContent('fist post sample content nothing special first')
            ->setPublished(new \DateTime('2024-12-18 09:00:00'))
            ->setSlug('test-post-first');
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('test post second')
            ->setAuthor('t ahmed')
            ->setContent('fist post sample content nothing special second')
            ->setPublished(new \DateTime('2024-12-16 10:00:00'))
            ->setSlug('test-post-second');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
