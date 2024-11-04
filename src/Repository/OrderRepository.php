<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
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
