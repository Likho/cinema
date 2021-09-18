<?php

namespace App\Controller;

use App\Entity\MovieTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class BookingsController extends BaseController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function index(): Response
    {
        return $this->render('bookings/index.html.twig', [
            'user' => $this->user
        ]);
    }

    public function create(MovieTime $movieTime): Response
    {
//        $movieTime->getMovieDate()->getMovie()->getTitle() //Title
        return $this->render('bookings/create.html.twig', [
            'movieTime' => $movieTime,
            'error' => "",
            'user' => $this->user,
            'pageTitle' => 'Book '
        ]);
    }
}