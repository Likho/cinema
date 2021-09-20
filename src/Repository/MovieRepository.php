<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\MovieDate;
use App\Entity\MovieTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function findUpcoming()
    {
        //Only display movies with dates in the future
        return $this->createQueryBuilder('m')
            ->innerJoin(
                MovieDate::class,
                'd',
                Join::WITH,
                'd.movie_id = m.id'
            )->innerJoin(
                MovieTime::class,
                't',
                Join::WITH,
                't.movie_date_id = d.id'
            )->where(
                'CONCAT(d.date, \' \',t.time) > CURRENT_TIMESTAMP()'
            )->groupBy('m.id')
            ->getQuery()
            ->getResult();
    }
}
