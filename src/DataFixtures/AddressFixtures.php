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
        $address = new Address();
        $address->setStreet("rue taison");
        $address->setPostalCode(57000);
        $address->setCity("Metz");
        $address->setCountry("France");
        
        $manager->persist($address);

        $manager->flush();

        $this->addReference("address_1",$address);
    }
}
