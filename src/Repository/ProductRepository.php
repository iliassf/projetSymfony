<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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


//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
