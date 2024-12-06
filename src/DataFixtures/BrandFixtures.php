<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const BRANDS = [
        'Chanel',
        'Dior',
        'Gucci',
        'Yves Saint Laurent',
        'Calvin Klein',
        'Givenchy',
        'Tom Ford',
        'Versace',
        'Hugo Boss',
        'Burberry',
        'Lancôme'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::BRANDS as $key => $brandName) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);

            $this->addReference('brand_' . $key, $brand);
        }

        $manager->flush();
    }
}
