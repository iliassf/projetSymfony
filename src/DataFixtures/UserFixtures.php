<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $em;
    private $hasher;

    // Constructor injection
    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $this->em = $em;
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setFirstName("Jean");
        $user->setLastName("Dujardin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setWallet(new Wallet());
        $user->setPassword($this->hasher->hashPassword($user,"test"));

        $user->setAddress($this->getReference("address_1"));
        
        $manager->persist($user);

        $this->addReference('user_admin', $user);

        $user2 = new User();
        $user2->setEmail('test@gmail.com');
        $user2->setFirstName("Vincent");
        $user2->setLastName("Cassel");
        $user2->setRoles(["ROLE_USER"]);
        $user2->setWallet(new Wallet());
        $user2->setPassword($this->hasher->hashPassword($user2,"test"));

        $user2->setAddress($this->getReference("address_1"));
        
        $manager->persist($user2);

        $this->addReference('user_test', $user2);

        $manager->flush();
    }
}
