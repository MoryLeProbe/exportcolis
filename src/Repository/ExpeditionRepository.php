<?php

namespace App\Repository;

use App\Entity\Expedition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expedition>
 */
class ExpeditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expedition::class);
    }

    /**
     * @return Expedition[] Returns an array of Expedition objects
     */
    public function findAllOrderedByIdDesc(): array
    {
            return $this->createQueryBuilder('c')
                ->orderBy('c.id', 'DESC')
                ->getQuery()
                ->getResult();
        }

    /**
     * @return Expedition[] Returns an array of Expedition objects matching the search query
     */
    public function findBySearchQuery(string $query): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.colis', 'c')
            ->where('e.numero LIKE :query')
            ->orWhere('e.type LIKE :query')
            ->orWhere('c.numero LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Expedition
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
