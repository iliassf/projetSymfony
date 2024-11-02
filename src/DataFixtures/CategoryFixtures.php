<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $category = new Category();
            $category->setName("Homme");
            $manager->persist($category);

            $category->setName("Femme");
            $manager->persist($category);

        $manager->flush();
    }
}
