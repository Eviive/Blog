<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $user1 = $this->getReference('user1');
        $user2 = $this->getReference('user2');

        $pyJsPost = $this->getReference('post_pyjs');
        $cppPost = $this->getReference('post_cpp');
        $aiPost = $this->getReference('post_ai');
        $devopsPost = $this->getReference('post_devops');
        $dbPost = $this->getReference('post_db');
        $javaPost = $this->getReference('post_java');

        $comments = [
            ['user' => $user1, 'post' => $pyJsPost, 'content' => 'I love JavaScript!'],
            ['user' => $user2, 'post' => $pyJsPost, 'content' => 'I\'m a Python fan, but I\'m open to new things.'],
            ['user' => $user2, 'post' => $pyJsPost, 'content' => 'Very interesting article!'],
            ['user' => $user1, 'post' => $cppPost, 'content' => 'Very educational!'],
            ['user' => $user2, 'post' => $cppPost, 'content' => 'I already knew C++, but still learned a lot, thank you !'],
            ['user' => $user1, 'post' => $aiPost, 'content' => 'ChatGPT is awesome!'],
            ['user' => $user2, 'post' => $aiPost, 'content' => 'I\'m kinda scared of AI...'],
            ['user' => $user1, 'post' => $devopsPost, 'content' => 'I\'m a DevOps engineer, I\'m glad to see this article!'],
            ['user' => $user2, 'post' => $devopsPost, 'content' => 'DevOps is fascinating!'],
            ['user' => $user1, 'post' => $dbPost, 'content' => 'Recently dropped my entire production database, wish I had read this article before.'],
            ['user' => $user2, 'post' => $dbPost, 'content' => 'Just started learning SQL, this article is very helpful!'],
            ['user' => $user1, 'post' => $javaPost, 'content' => 'Code snippets are very helpful!'],
            ['user' => $user2, 'post' => $javaPost, 'content' => 'I did not know Java could be used for mobile apps!'],
        ];

        foreach ($comments as $commentData) {
            $comment = new Comment();
            $comment->setPost($commentData['post']);
            $comment->setUser($commentData['user']);
            $comment->setContent($commentData['content']);
            $comment->setValid(true);
            $comment->setCreatedAt(new DateTime());
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
