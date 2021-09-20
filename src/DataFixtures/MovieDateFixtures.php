<?php

namespace App\DataFixtures;

use App\Entity\MovieDate;
use App\Repository\MovieRepository;
use Carbon\Carbon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieDateFixtures extends Fixture implements DependentFixtureInterface
{

    protected $movieRepository;
    function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            foreach ($this->movieRepository->findAll() as $movie) {
                $date = Carbon::now();
                $movieDate = new MovieDate();
                $movieDate->setMovie($movie);
                $movieDate->setMovieId($movie->getId());
                $movieDate->setDate($date->addDays($i));
                $movieDate->setCreatedAt(new \DateTimeImmutable('now'));
                $movieDate->setUpdatedAt(new \DateTimeImmutable('now'));
                $manager->persist($movieDate);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CinemaFixtures::class,
            MovieFixtures::class,
        ];
    }
}