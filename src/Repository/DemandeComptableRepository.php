<?php

namespace App\Repository;

use App\Entity\DemandeComptable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DemandeComptable|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeComptable|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeComptable[]    findAll()
 * @method DemandeComptable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeComptableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeComptable::class);
    }

    // /**
    //  * @return DemandeComptable[] Returns an array of DemandeComptable objects
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
    public function findOneBySomeField($value): ?DemandeComptable
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
