<?php

namespace App\Repository;

use App\Entity\DemandeCSE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeCSE|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeCSE|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeCSE[]    findAll()
 * @method DemandeCSE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeCSERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeCSE::class);
    }

    // /**
    //  * @return DemandeCSE[] Returns an array of DemandeCSE objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DemandeCSE
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
