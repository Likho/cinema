<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    protected $movieRepository;
    protected $user;
    function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('movies/index.html.twig', [
            'pageTitle' => 'Upcoming Movies!',
            'movies' => $this->movieRepository->findUpcoming(),
            'user' => $this->getUser(),
        ]);
    }

    public function view(Movie $movie): Response
    {
        return $this->render('movies/view.html.twig', [
            'pageTitle' => $movie->getTitle(),
            'movie' => $movie,
            'user' => $this->getUser(),
        ]);
    }
}
