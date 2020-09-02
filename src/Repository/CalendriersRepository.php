<?php

namespace App\Repository;

use App\Entity\Calendriers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Calendriers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendriers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendriers[]    findAll()
 * @method Calendriers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendriersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendriers::class);
    }

    // /**
    //  * @return Calendriers[] Returns an array of Calendriers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Calendriers
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
