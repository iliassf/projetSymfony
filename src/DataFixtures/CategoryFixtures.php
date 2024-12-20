<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
            $category = new Category();
            $category->setName("Homme");
            $manager->persist($category);

            $category2 = new Category();
            $category2->setName("Femme");
            $manager->persist($category2);

            $category3 = new Category();
            $category3->setName("Mixte");
            $manager->persist($category3);

        $manager->flush();
    }
}
