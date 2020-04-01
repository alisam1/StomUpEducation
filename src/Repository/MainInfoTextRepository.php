<?php

namespace App\Repository;

use App\Entity\MainInfoText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MainInfoText|null find($id, $lockMode = null, $lockVersion = null)
 * @method MainInfoText|null findOneBy(array $criteria, array $orderBy = null)
 * @method MainInfoText[]    findAll()
 * @method MainInfoText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MainInfoTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MainInfoText::class);
    }

    // /**
    //  * @return MainInfoText[] Returns an array of MainInfoText objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MainInfoText
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
