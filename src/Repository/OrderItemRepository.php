<?php

namespace App\Repository;

use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @extends ServiceEntityRepository<OrderItem>
 */
class OrderItemRepository extends ServiceEntityRepository
{
    private TranslatorInterface $translator;
    public function __construct(ManagerRegistry $registry, TranslatorInterface $translator)
    {
        parent::__construct($registry, OrderItem::class);
        $this->translator = $translator;
    }

    public function totalAmountByMonth(string $language): array
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

            foreach ($totalAmountByMonth as &$value) {
                $month = substr($value['month'], 5); 
                $value['month'] = $this->translator->trans("months.$month", [], null, $language);
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
