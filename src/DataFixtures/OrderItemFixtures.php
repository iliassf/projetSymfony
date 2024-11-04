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

        // Récupérer les commandes et produits existants
        $orders = $manager->getRepository(Order::class)->findAll();
        $products = $manager->getRepository(Product::class)->findAll();

        foreach ($orders as $order) {
            // Créer un ou plusieurs OrderItems pour chaque commande
            for ($i = 0; $i < mt_rand(1, 3); $i++) {
                $orderItem = new OrderItem();
                $orderItem->setCommande($order);
                $orderItem->setProduct($faker->randomElement($products));
                $orderItem->setQuantity(mt_rand(1, 5));
                $orderItem->setProductPrice($orderItem->getProduct()->getPrice()); // S'il existe un prix dans Product

                $manager->persist($orderItem);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Indique que OrderFixtures et ProductFixtures doivent être chargées avant cette fixture
        return [
            OrderFixtures::class,
            ProductFixtures::class,
        ];
    }
}
