<?php

namespace App\DataFixtures;

use App\Entity\MovieTime;
use App\Repository\MovieDateRepository;
use App\Repository\MovieRepository;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieTimeFixtures extends Fixture implements DependentFixtureInterface
{

    protected $movieDateRepositoryRepository;
    function __construct(MovieDateRepository $movieDateRepositoryRepository)
    {
        $this->movieDateRepositoryRepository = $movieDateRepositoryRepository;
    }
    public function getDependencies(): array
    {
        return [
            CinemaFixtures::class,
            TheaterFixtures::class,
            MovieFixtures::class,
            MovieDateFixtures::class,
            TheaterFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        $movieDates = $this->movieDateRepositoryRepository->findAll();
        for ($i = 1; $i <= 3; $i++) {
            foreach ($movieDates as $movieDate) {
                $date = Carbon::createFromTime(10);
                $movieTime = new MovieTime();
                $movieTime->setMovieDate($movieDate);
                $movieTime->setTime($date->addHours($i));
                $movieTime->setTicketsBooked(0);
                $movieTime->setTheater($movieDate->getMovie()->getTheater());
                $movieTime->setTheaterId($movieDate->getMovie()->getTheater()->getId());
                $movieTime->setCreatedAt(new \DateTimeImmutable('now'));
                $movieTime->setUpdatedAt(new \DateTimeImmutable('now'));
                $manager->persist($movieTime);
            }
        }
        $manager->flush();
    }
}