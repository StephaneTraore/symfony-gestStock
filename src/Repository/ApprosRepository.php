<?php

namespace App\Repository;

use App\Entity\Appros;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appros>
 *
 * @method Appros|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appros|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appros[]    findAll()
 * @method Appros[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApprosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appros::class);
    }

//    /**
//     * @return Appros[] Returns an array of Appros objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Appros
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
