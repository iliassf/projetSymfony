<?php

namespace App\Repository;

use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderItem>
 */
class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

    public function totalAmountByMonth(): array
    {
        $endDate = new \DateTimeImmutable("now");
        $startDate = $endDate->modify("-1 year");

        $totalAmountByMonth = $this->createQueryBuilder('oi')
            ->select("SUBSTRING(o.createdAt, 1, 7) as month", 'SUM(oi.productPrice * oi.quantity) as totalAmount')
            ->join('oi.commande', 'o')
            ->where('o.createdAt BETWEEN :start AND :end')
            ->groupBy('month')
            ->orderBy('month', 'DESC')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getResult();

        $monthNames = ["01" => 'Janvier', "02" => 'Fevrier', "03" => 'Mars', "04" => 'Avril', "05" => 'Mai', "06" => 'Juin', 
            "07" => 'Juillet', "08" => 'Aout', "09" => 'Septembre', "10" => 'Octobre', "11" => 'Novembre', "12" => 'Decembre'];

        foreach ($totalAmountByMonth as &$value) {
            $value['month'] = $monthNames[substr($value['month'],5)];
        }

        return $totalAmountByMonth;
    }

    //    /**
    //     * @return OrderItem[] Returns an array of OrderItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OrderItem
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
