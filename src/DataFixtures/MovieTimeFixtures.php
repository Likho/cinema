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
            MovieFixtures::class,
            MovieDateFixtures::class,
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
                $movieTime->setCreatedAt(new \DateTimeImmutable('now'));
                $movieTime->setUpdatedAt(new \DateTimeImmutable('now'));
                $manager->persist($movieTime);

            }
        }
        $manager->flush();
    }
}