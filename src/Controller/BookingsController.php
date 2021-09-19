<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\MovieTime;
use App\Repository\BookingRepository;
use App\Repository\MovieTimeRepository;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class BookingsController extends BaseController
{
    protected $bookingRepository;
    protected $movieTimeRepository;
    protected $session;
    public function __construct(
        ContainerInterface $container,
        BookingRepository $bookingRepository,
        MovieTimeRepository $movieTimeRepository,
        Session $session
    ){
        parent::__construct($container);
        $this->bookingRepository = $bookingRepository;
        $this->movieTimeRepository = $movieTimeRepository;
        $this->session = $session;
    }

    public function index(): Response
    {
        return $this->render('bookings/index.html.twig', [
            'user' => $this->user,
            'bookings' => $this->user->getBookings()
        ]);
    }

    /**
     * @param MovieTime $movieTime
     * @return Response
     */
    public function create(MovieTime $movieTime): Response
    {
        $error = "";
        foreach ($this->session->getFlashBag()->get('error', []) as $message) {
            $error = $message;
        }
        return $this->render('bookings/create.html.twig', [
            'movieTime' => $movieTime,
            'error' => $error,
            'user' => $this->user,
            'pageTitle' => "Book {$movieTime->getMovieDate()->getMovie()->getTitle()}",
            'availableSeats' => $movieTime->getTheater()->getMaxSeats() - $movieTime->getTicketsBooked()
        ]);
    }

    /**
     * Add a new booking
     *
     * @param Request $request
     * @param MovieTime $movieTime
     * @return RedirectResponse
     */
    public function add(Request $request, MovieTime $movieTime): RedirectResponse
    {
        $request->request->set('user', $this->user);
        try {
            $booking = $this->bookingRepository->save($request, $movieTime);

            //Update theater available tickets
            $this->movieTimeRepository->addToBookedTickets($booking);
            //Redirect to bookings page
            return $this->redirectToRoute('bookings');
        } catch (\Exception $exception) {
            $this->session->getFlashBag()->add('error', $exception->getMessage());
            return $this->redirect("/bookings/create/{$movieTime->getId()}");
        }

    }

    public function cancel(Booking $booking): JsonResponse
    {
        $now = Carbon::now('+02:00');
        $date = $booking->getMovieTime()->getMovieDate()->getDate()->format('Y-m-d');
        $time = $booking->getMovieTime()->getTime()->format('H:i');
        $movieDate = Carbon::createFromFormat('Y-m-d H:i',  "{$date} {$time}");

        if ($now->diffInHours($movieDate) > 1) {
            try {
                //Reinstate tickets
                $this->bookingRepository->cancel($booking);
                $this->movieTimeRepository->replaceMovieTickets($booking);
                return JsonResponse::fromJsonString('{ "response": success }');
            } catch (\Exception $exception) {
                return JsonResponse::fromJsonString(json_encode(['response' => $exception->getMessage()]));
            }
        } else {
            return JsonResponse::fromJsonString('{ "response": "Cannot cancel an an hour or less before." }');
        }
    }
}