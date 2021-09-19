<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\MovieTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovieTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieTime[]    findAll()
 * @method MovieTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieTime::class);
    }

    public function addToBookedTickets(Booking $booking): void
    {
        $currentlyBooked = $booking->getMovieTime()->getTicketsBooked();
        $booking->getMovieTime()->setTicketsBooked($currentlyBooked + $booking->getNumberOfTickets());
        $this->_em->persist($booking->getMovieTime());
        $this->_em->flush();
    }

    public function replaceMovieTickets(Booking $booking): void
    {
        $currentlyBooked = $booking->getMovieTime()->getTicketsBooked();
        $booking->getMovieTime()->setTicketsBooked($currentlyBooked - $booking->getNumberOfTickets());
        $this->_em->persist($booking->getMovieTime());
        $this->_em->flush();
    }
}
