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

        // Créer au moins une commande pour chaque mois des 15 derniers mois
        for ($monthOffset = 0; $monthOffset < 15; $monthOffset++) {
            // Obtenir la date du mois en cours en retranchant $monthOffset mois à la date actuelle
            $date = $currentDate->modify("-$monthOffset months");
            
            // Créer au moins une commande par mois
            $order = new Order();
            $order->setUser($faker->randomElement([
                $this->getReference('user_admin'),
                $this->getReference('user_test')
            ]));
            $order->setReference($faker->unique()->word);
            $order->setCreatedAt($date);
            $order->setStatus(Step::Preparation);

            $manager->persist($order);
        }
        
        // Créer quelques commandes supplémentaires pour avoir plus de données
        for ($i = 0; $i < 10; $i++) {
            $order = new Order();
            $order->setUser($faker->randomElement([
                $this->getReference('user_admin'),
                $this->getReference('user_test')
            ]));
            $order->setReference($faker->unique()->word);
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
