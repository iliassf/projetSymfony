<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Enum\Available;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public const NAMES = [
        'Chanel No. 5',
        'Miss Dior',
        'Gucci Bloom',
        'Black Opium',
        'CK One',
        'Gentleman',
        'Tobacco Vanille',
        'Versace Eros',
        'Boss Bottled',
        'Burberry Her',
        'La Vie Est Belle'
    ];
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $categories = $manager->getRepository('App\Entity\Category')->findAll();

        foreach (self::NAMES as $key => $productName) {

            $product = new Product();
            $product->setName($productName)
                    ->setPrice($faker->randomFloat(2, 10, 100))
                    ->setDescription("L'eau de parfum Bois d'Argent incarne une silhouette florale et boisée à l'élégance olfactive universelle. Son sillage est celui d'un accord de bois piqué d'une note d'iris rayonnante et richement poudrée, boutonnée d'une note d'encens presque mystique. Pièce favorite qui s’assortit d’un rien et s’assemble avec tout, cette eau de parfum mixte révèle l'évidence d'une silhouette sans artifice, presque dépouillée : l'incarnation pure du raffinement Dior. Un essentiel de La Collection Privée Christian Dior, au sillage signature charismatique et singulier qui signe un retour aux matières premières brutes sublimées.")
                    ->setStock($faker->numberBetween(0, 50))
                    ->setStatus($faker->randomElement(Available::cases()))
                    ->setCategory($faker->randomElement($categories))
                    ->setBrand($this->getReference('brand_'.$key))
                    ->setImage($this->getReference('image_'.$key));

            $manager->persist($product);
        }

        $manager->flush();
    }
}