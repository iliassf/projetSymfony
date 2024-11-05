<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Order::class);
    }

    public function paginateOrder(int $page):PaginationInterface{
        return $this->paginator->paginate(
            $this->createQueryBuilder("o"),
            $page, 
            10,
            [
                "sortFieldAllowList"=>["o.reference","o.createdAt","o.status"]
            ]);
    }

    public function fiveLatestOrder():array
    {
        return $this->createQueryBuilder('p')
        ->orderBy('p.createdAt', 'DESC')
        ->getQuery()
        ->setMaxResults(5)
        ->getResult();
    }

}
