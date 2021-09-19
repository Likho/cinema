<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\MovieTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Request $request, MovieTime $movieTime): Booking
    {
        try {
            $booking = new Booking();
            $booking->setUser($request->request->get('user'));
            $booking->setMovieTime($movieTime);
            $booking->setNumberOfTickets($request->request->get('tickets'));
            $booking->setReferenceNumber(bin2hex(random_bytes(4)));
            $booking->setActive(true);
            $this->_em->persist($booking);
            $this->_em->flush();

            return $booking;
        } catch (Exception $exception) {
            throw new \Exception("Unable to create booking");
        }
    }

    public function cancel(Booking $booking)
    {
        try {
            $booking->setActive(false);
            $this->_em->persist($booking);
            $this->_em->flush();
        } catch (Exception $exception) {
            throw new \Exception("Unable to cancel booking");
        }

    }
}
