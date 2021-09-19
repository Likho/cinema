<?php

namespace App\DataFixtures;

use App\Entity\Theater;
use App\Repository\CinemaRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TheaterFixtures extends Fixture implements DependentFixtureInterface
{
    protected $cinemaRepository;
    public function __construct(CinemaRepository $cinemaRepository)
    {
        $this->cinemaRepository = $cinemaRepository;
    }

    public function getDependencies(): array
    {
        return [
            CinemaFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        //Get Cinemas first
        foreach ($this->cinemaRepository->findAll() as $cinema) {
            for ($i = 1; $i <= 2; $i++) {
                $numberWords = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                $theater = new Theater();
                $theater->setCinema($cinema);
                $theater->setCinemaId($cinema->getId());
                $theater->setName("Theater_{$numberWords->format($i)}");
                $theater->setMaxSeats(30);
                $manager->persist($theater);
            }
        }
        $manager->flush();
    }
}