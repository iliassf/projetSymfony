<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public const URL=[
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwbab29bf5/images/hi-res/SKU/SKU_4/337229_swatch.jpg",
        "https://www.sephora.fr/dw/image/v2/BCVW_PRD/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwa9103e88/images/hi-res/SKU/SKU_2441/564564_swatch.jpg?sw=585&sh=585&sm=fit",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw194e383f/images/hi-res/SKU/SKU_4599/404959_swatch.jpeg",
        "https://www.sephora.fr/dw/image/v2/BCVW_PRD/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw48aa61fa/images/hi-res/SKU/SKU_4911/703799_swatch.jpg?sw=585&sh=585&sm=fit",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw0e9ef7d2/images/hi-res/SKU/SKU_4611/219009_swatch.jpeg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw3942016e/images/hi-res/SKU/SKU_2885/580926_swatch.jpg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwe7a6a8f8/images/hi-res/SKU/SKU_2002/436143_swatch.jpg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw1c42081c/images/hi-res/SKU/SKU_1687/528281_swatch.jpg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwb2c24031/images/hi-res/SKU/SKU_6018/96666_swatch.jpg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwf0b70c01/images/hi-res/SKU/SKU_3375/614628_swatch.jpg",
        "https://www.sephora.fr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw22b0e072/images/hi-res/SKU/SKU_2/254230_swatch.jpg"
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::URL as $key => $url) {
            $image = new Image();
            $image->setUrl($url);
            $manager->persist($image);

            $this->addReference('image_' . $key, $image);
        }

        $manager->flush();
    }
}