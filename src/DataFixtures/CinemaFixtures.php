<?php

namespace App\DataFixtures;

use App\Entity\Cinema;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CinemaFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $cinemaOne = new Cinema();
        $cinemaOne->setName('Cavendish Square');
        $cinemaOne->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaOne->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaOne);

        $cinemaTwo = new Cinema();
        $cinemaTwo->setName('V&A Waterfront');
        $cinemaTwo->setCreatedAt(new \DateTimeImmutable('now'));
        $cinemaTwo->setUpdatedAt(new \DateTimeImmutable('now'));
        $manager->persist($cinemaTwo);

        $manager->flush();
    }
}