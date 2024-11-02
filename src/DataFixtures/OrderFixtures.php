<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Address;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository('App\Entity\User')->findAll();

        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                $order = new Order();
                $order->setReference($faker->unique()->word);
                $order->setCreatedAt(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s')));
                $order->setStatus($faker->randomElement(['en préparation', 'expédiée', 'livrée', 'annulée']));

                $manager->persist($order);
            }
        }
        $manager->flush();
    }
}
