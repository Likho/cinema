<?php

namespace App\Tests\Factory;

use App\Entity\Cinema;

class CinemaFactory
{
    public static function createCinema(): Cinema
    {
        $cinema = new Cinema();
        $cinema->setName('Test');
        $cinema->setCreatedAt(new \DateTimeImmutable('now'));
        $cinema->setUpdatedAt(new \DateTimeImmutable('now'));

        return $cinema;
    }
}