<?php

namespace App\Tests\Factory;

use App\Entity\Cinema;
use App\Entity\Movie;
use App\Entity\Theater;

class MovieFactory
{
    public static function createMovie(Cinema $cinemaFactory, Theater $theaterFactory): Movie
    {
        $movie = new Movie();
        $movie->setTitle('Test movie');
        $movie->setCinema($cinemaFactory);
        $movie->setTheater($theaterFactory);

        return $movie;

    }
}