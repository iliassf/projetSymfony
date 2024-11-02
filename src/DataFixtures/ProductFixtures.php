<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Product;
use App\Entity\Image;
use App\Enum\Available;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $categories = $manager->getRepository('App\Entity\Category')->findAll();

        if (empty($categories)) {
            throw new \Exception("No categories found! Please load CategoryFixtures first.");
        }

        for ($i = 0; $i < 11; $i++) {
            $productName = $faker->word;
            // echo "Generated product name: $productName\n"; // Debug

            $product = new Product();
            $product->setName($productName) // Assurez-vous que cette ligne génère un nom
                    ->setPrice($faker->randomFloat(2, 10, 100))
                    ->setDescription("L'eau de parfum Bois d'Argent incarne une silhouette florale et boisée à l'élégance olfactive universelle. Son sillage est celui d'un accord de bois piqué d'une note d'iris rayonnante et richement poudrée, boutonnée d'une note d'encens presque mystique.

Pièce favorite qui s’assortit d’un rien et s’assemble avec tout, cette eau de parfum mixte révèle l'évidence d'une silhouette sans artifice, presque dépouillée : l'incarnation pure du raffinement Dior.

Un essentiel de La Collection Privée Christian Dior, au sillage signature charismatique et singulier qui signe un retour aux matières premières brutes sublimées.")
                    ->setStock($faker->numberBetween(0, 50))
                    ->setStatus($faker->randomElement(Available::cases())) // Utilisation de l'Enum
                    ->setCategory($faker->randomElement($categories));

            // Création d'images
            for ($j = 0; $j < 3; $j++) {
                $image = new Image();
                $image->setUrl($faker->randomElement(["https://www.sephora.fr/dw/image/v2/BCVW_PRD/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw3af8723a/images/hi-res/SKU/SKU_5687/736505_swatch.jpg?sw=240&sh=240&sm=fit","https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw194feaa0/images/hi-res/SKU/SKU_2508/427366_swatch.jpg","https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwafa29949/images/hi-res/SKU/SKU_5593/445515_swatch.jpg"]));
                $product->setImage($image);
                $manager->persist($image);
            }

            // Création de tailles
            for ($k = 0; $k < 5; $k++) {
                $brand = new Brand();
                $brand->setName($faker->randomElement( ["dior", "hugo boss"]))
                     ->addProduct($product);
                $manager->persist($brand);
            }

            $manager->persist($product);
        }

        $manager->flush();
    }
}