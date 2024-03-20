<?php

namespace App\Repository;

use App\Entity\SMS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SMS>
 *
 * @method SMS|null find($id, $lockMode = null, $lockVersion = null)
 * @method SMS|null findOneBy(array $criteria, array $orderBy = null)
 * @method SMS[]    findAll()
 * @method SMS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SMSRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SMS::class);
    }

    //    /**
    //     * @return SMS[] Returns an array of SMS objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SMS
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
