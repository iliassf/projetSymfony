<?php

namespace App\DataFixtures;

use App\Entity\OrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Order;
use App\Entity\Product;

class OrderItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $orders = $manager->getRepository(Order::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        foreach ($orders as $order) {
            for ($i = 0; $i < mt_rand(1, 3); $i++) {
                $orderItem = new OrderItem();
                $orderItem->setCommande($order);
                $orderItem->setProduct($faker->randomElement($products));
                $orderItem->setQuantity(mt_rand(1, 5));
                $orderItem->setProductPrice($orderItem->getProduct()->getPrice());

                $manager->persist($orderItem);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OrderFixtures::class,
            ProductFixtures::class,
        ];
    }
}
