<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $users = $manager->getRepository('App\Entity\User')->findAll();

        foreach ($users as $user) {
            $address = new Address();
            $address->setStreet($faker->streetAddress);
            $address->setPostalCode($faker->postcode);
            $address->setCity($faker->city);
            $address->setCountry($faker->country);
            $address->addUser($user);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
