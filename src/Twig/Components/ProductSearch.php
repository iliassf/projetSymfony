<?php
// src/Twig/Components/ProductSearch.php
namespace App\Twig\Components;

use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class ProductSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function getProducts(): array
    {
        return $this->productRepository->search($this->query);
    }

}