<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieDate;
use App\Repository\MovieRepository;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends BaseController
{
    protected $movieRepository;
    function __construct(MovieRepository $movieRepository, ContainerInterface $container)
    {
        parent::__construct($container);
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('movies/index.html.twig', [
            'pageTitle' => 'Book a movie!',
            'movies' => $this->movieRepository->findUpcoming(),
            'user' => $this->user,
        ]);
    }

    public function view(Movie $movie): Response
    {
//        $movie = $this->movieRepository->findById($movie->getId());
        return $this->render('movies/view.html.twig', [
            'pageTitle' => $movie->getTitle(),
            'movie' => $movie,
            'user' => $this->user,
        ]);
    }
}
