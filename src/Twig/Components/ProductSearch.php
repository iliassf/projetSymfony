<?php
// src/Twig/Components/ProductSearch.php
namespace App\Twig\Components;

use App\Repository\ProductRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;

#[AsLiveComponent]
class ProductSearch
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';
    //private RequestStack $requestStack;
    public function __construct(private ProductRepository $productRepository, /* RequestStack $requestStack*/)
    {
        //$this->requestStack = $requestStack;
    }

    public function getProducts(): array
    {
        /*
        $request = $this->requestStack->getCurrentRequest();
        $page = $request->query->getInt('page',1);
        */
        return $this->productRepository->search($this->query);
    }
}