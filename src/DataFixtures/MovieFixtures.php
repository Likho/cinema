<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Repository\CinemaRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
    protected $cinemaRepository;
    public function __construct(CinemaRepository $cinemaRepository)
    {
        $this->cinemaRepository = $cinemaRepository;
    }

    public function load(ObjectManager $manager)
    {
        $cinemas = $this->cinemaRepository->findAll();
        /********************************************************************************/
        /* Cinema One
        /********************************************************************************/
        $cinemaOne = $this->cinemaRepository->find($cinemas[0]);

        $cinemaOneMovieOne = new Movie();
        $cinemaOneMovieOne->setCinema($cinemaOne);
        $cinemaOneMovieOne->setTitle('PAW Patrol: The Movie');
        $cinemaOneMovieOne->setImage('https://numetro.co.za/wp-content/uploads/movies_images/poster/5850-1-6-3-1628884416.jpg');
        $cinemaOneMovieOne->setDescription('The PAW Patrol is on a roll! When their biggest rival, Humdinger, becomes Mayor of nearby Adventure City and starts wreaking havoc, Ryder and everyoneʼs favourite heroic pups kick into high gear to face the challenge head-on! While one pup must face his past in Adventure City, the team finds help from a new ally, the savvy dachshund Liberty. Together, armed with exciting new gadgets and gear, the PAW Patrol fights to save the citizens of Adventure City');
        $cinemaOneMovieOne->setDuration(88);
        $cinemaOneMovieOne->setAgeRestriction('ALL');
        $cinemaOneMovieOne->setCinemaId($cinemaOne->getId());
        $cinemaOneMovieOne->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaOneMovieOne->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaOneMovieOne);

        $cinemaOneMovieTwo = new Movie();
        $cinemaOneMovieTwo->setCinema($cinemaOne);
        $cinemaOneMovieTwo->setTitle('Boss Baby: Family Business');
        $cinemaOneMovieTwo->setImage('https://numetro.co.za/wp-content/uploads/movies_images/poster/4721-1-4-3-1628664478.jpg');
        $cinemaOneMovieTwo->setDescription('The Templeton brothers, Tim and his boss baby little bro, Ted, have become adults and drifted away from each other. Tim is now a married, stay-at-home dad. Ted is a hedge fund CEO. But, a new boss baby with a cutting-edge approach and a can-do attitude is about to bring them together again … and inspire a new family business.');
        $cinemaOneMovieTwo->setDuration(120);
        $cinemaOneMovieTwo->setAgeRestriction('PG13');
        $cinemaOneMovieTwo->setCinemaId($cinemaOne->getId());
        $cinemaOneMovieTwo->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaOneMovieTwo->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaOneMovieTwo);

        /********************************************************************************/
        /* Cinema Two
        /********************************************************************************/
        $cinemaTwo = $this->cinemaRepository->find($cinemas[1]);

        $cinemaTwoMovieOne = new Movie();
        $cinemaTwoMovieOne->setCinema($cinemaTwo);
        $cinemaTwoMovieOne->setTitle('Around the World in 80 Days');
        $cinemaTwoMovieOne->setImage('https://numetro.co.za/wp-content/uploads/movies_images/poster/6000-1-2-3-1628665882.jpg');
        $cinemaTwoMovieOne->setDescription('Jean Passepartout is a young and scholarly marmoset who always dreams of becoming and explorer. One day, he croses paths with Phileas Fogg, a reckless and greedy frog, eager to take on a bet to circle the globe in 80 days and earn 10 million clams in the process.');
        $cinemaTwoMovieOne->setDuration(96);
        $cinemaTwoMovieOne->setAgeRestriction('ALL');
        $cinemaTwoMovieOne->setCinemaId($cinemaTwo->getId());
        $cinemaTwoMovieOne->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaTwoMovieOne->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaTwoMovieOne);

        $cinemaTwoMovieTwo = new Movie();
        $cinemaTwoMovieTwo->setCinema($cinemaTwo);
        $cinemaTwoMovieTwo->setTitle('Luca');
        $cinemaTwoMovieTwo->setImage('https://numetro.co.za/wp-content/uploads/movies_images/poster/5230-1-5-3-1620385876.jpg');
        $cinemaTwoMovieTwo->setDescription('A young boy experiences an unforgettable seaside summer on the Italian Riviera filled with gelato, pasta and endless scooter rides. Luca shares these adventures with his newfound best friend, but all the fun is threatened by a deeply-held secret: his friend is a sea monster from another world just below the ocean’s surface.');
        $cinemaTwoMovieTwo->setDuration(95);
        $cinemaTwoMovieTwo->setAgeRestriction('PG V');
        $cinemaTwoMovieTwo->setCinemaId($cinemaTwo->getId());
        $cinemaTwoMovieTwo->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaTwoMovieTwo->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaTwoMovieTwo);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CinemaFixtures::class,
        ];
    }
}