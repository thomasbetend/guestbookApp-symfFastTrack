<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFictures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comment = new Comment();
        $comment->setAuthor('Jeannot');
        $manager->persist($comment);
        
        $manager->flush();
    }
}
