<?php

namespace App\Tests\Factory;

use App\Entity\Cinema;
use App\Entity\Theater;

class TheaterFactory
{
    public static function createTheater(Cinema $cinemaFactory): Theater
    {
        $theater = new Theater();
        $theater->setName('Test Theater');
        $theater->setCinema($cinemaFactory);
        $theater->setMaxSeats(30);

        return $theater;
    }
}