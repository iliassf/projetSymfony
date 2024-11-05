<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
    }
    
    public function countProductsByCategory(): array
    {
        return $this->createQueryBuilder('p')
            ->select('c.name as category', 'COUNT(p.id) as productCount')
            ->join('p.category', 'c')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }

    public function countProductsByStatus(): array
    {
        $totalProducts = $this->createQueryBuilder('p')
        ->select('COUNT(p.id)')
        ->getQuery()
        ->getSingleScalarResult();

        return $this->createQueryBuilder('p')
            ->select('p.status as status', '(COUNT(p.id) * 100 / :total) as proportion')
            ->groupBy('status')
            ->setParameter('total', $totalProducts)
            ->getQuery()
            ->getResult();
    }

    public function paginateProduct(int $page):PaginationInterface{
        return $this->paginator->paginate(
            $this->createQueryBuilder("p"),
            $page, 
            10);
    }
}
