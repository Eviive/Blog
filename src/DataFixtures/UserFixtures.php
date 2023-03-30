<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setUsername('Blog Admin');
        $user->setPassword($this->hasher->hashPassword($user, 'test123'));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setUsername('Blog User');
        $user->setPassword($this->hasher->hashPassword($user, 'test123'));
        $this->addReference('user', $user);
        $manager->persist($user);

        $manager->flush();
    }
}
