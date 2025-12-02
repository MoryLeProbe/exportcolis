<?php

namespace App\Repository;

use App\Entity\HistoriqueColis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoriqueColis>
 */
class HistoriqueColisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriqueColis::class);
    }

    /**
     * @return HistoriqueColis[] Returns an array of HistoriqueColis objects
     */
    public function findAllOrderedByDateActionDesc(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.dateAction', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?HistoriqueColis
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
