<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $user = $this->getReference('user');
        $pyJsPost = $this->getReference('post_pyjs');

        if ($pyJsPost instanceof Post && $user instanceof User) {
            $comment = new Comment();
            $comment->setUser($user);
            $comment->setContent('This is a comment');
            $comment->setValid(true);
            $comment->setCreatedAt(new \DateTime());
            $comment->setPost($pyJsPost);
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            PostFixtures::class,
        ];
    }
}
