<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         // Assumez que vous avez déjà des produits créés
        $products = $manager->getRepository('App\Entity\Product')->findAll();

        foreach ($products as $product) {
            $image = new Image();
            $image->setUrl("https://encrypted-tbn0.gstatic.com/shopping?q=tbn:ANd9GcSO5SBck7fL2ctT8shzcwdDyuI91OKla7f0sfwH7oy7RJVmDp_QdwgahGCTQQJxBhTn8PZhadl7aWZ0n6YlvH3-Y7WqxhBvCAjE6jM7JN4&usqp=CAc");
            $image->setProduct($product);
            $manager->persist($image);
        }

        $manager->flush();
    }
}