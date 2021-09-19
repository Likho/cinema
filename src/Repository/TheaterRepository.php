<?php

namespace App\Repository;

use App\Entity\Theater;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theater|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theater|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theater[]    findAll()
 * @method Theater[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheaterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theater::class);
    }

     /**
      * @return Theater[] Returns an array of Theater objects
      */
    public function findByCinemaId($cinemaId)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.cinema_id = :val')
            ->setParameter('val', $cinemaId)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Theater
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
