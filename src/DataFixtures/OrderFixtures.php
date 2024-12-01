<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Enum\Step;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $currentDate = new \DateTimeImmutable('now');

        for ($monthOffset = 0; $monthOffset < 15; $monthOffset++) {
            $date = $currentDate->modify("-$monthOffset months");
            
            $order = new Order();
            $order->setUser($faker->randomElement([
                $this->getReference('user_admin'),
                $this->getReference('user_test')
            ]));
            $order->setReference(uniqid('ORD_'));
            $order->setCreatedAt($date);
            $order->setStatus(Step::Preparation);

            $manager->persist($order);
        }
        
        for ($i = 0; $i < 10; $i++) {
            $order = new Order();
            $order->setUser($faker->randomElement([
                $this->getReference('user_admin'),
                $this->getReference('user_test')
            ]));
            $order->setReference(uniqid('ORD_'));
            $order->setCreatedAt(new \DateTimeImmutable($faker->dateTimeThisYear()->format('Y-m-d H:i:s')));
            $order->setStatus($faker->randomElement([
                Step::Preparation,
                Step::Expediee,
                Step::Livree,
                Step::Annulee
            ]));

            $manager->persist($order);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class, // Indiquer que OrderFixtures dépend de UserFixtures
        ];
    }
}
