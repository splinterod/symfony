<?php

namespace App\Repository;

use App\Entity\Prout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prout[]    findAll()
 * @method Prout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prout::class);
    }

    // /**
    //  * @return Prout[] Returns an array of Prout objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prout
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
