<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryNames = [
            'Languages',
            'Web',
            'Mobile', // no article
            'Databases', // no article
            'DevOps',
            'AI',
            'Cybersecurity', // no article
            'Career',
            'Snippets',
            'Cloud',
        ];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $this->addReference('category_' . strtolower($name), $category);
        }

        $manager->flush();
    }
}
