<?php

namespace App\Repository;

use App\Entity\SitesInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SitesInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitesInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitesInfo[]    findAll()
 * @method SitesInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SitesInfo::class);
    }

    // /**
    //  * @return SitesInfo[] Returns an array of SitesInfo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SitesInfo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
