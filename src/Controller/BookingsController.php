<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\MovieTime;
use App\Repository\BookingRepository;
use App\Repository\MovieTimeRepository;
use Carbon\Carbon;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class BookingsController extends AbstractController
{
    protected $bookingRepository;
    protected $movieTimeRepository;
    protected $requestStack;

    public function __construct(
        BookingRepository $bookingRepository,
        MovieTimeRepository $movieTimeRepository,
        RequestStack $requestStack
    ){
        $this->bookingRepository = $bookingRepository;
        $this->movieTimeRepository = $movieTimeRepository;
        $this->requestStack = $requestStack;
    }

    public function index(): Response
    {
        $message = $this->requestStack->getSession()->get('success');
        $this->requestStack->getSession()->remove('success');

        return $this->render('bookings/index.html.twig', [
            'user' => $this->getUser(),
            'bookings' => $this->getUser()->getBookings(),
            'successMessage' => $message
        ]);
    }

    /**
     * @param MovieTime $movieTime
     * @return Response
     */
    public function create(MovieTime $movieTime): Response
    {
        return $this->render('bookings/create.html.twig', [
            'movieTime' => $movieTime,
            'error' => $this->requestStack->getSession()->get('error'),
            'user' => $this->getUser(),
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
        $request->request->set('user', $this->getUser());
        try {
            $booking = $this->bookingRepository->save($request, $movieTime);

            //Update theater available tickets
            $this->movieTimeRepository->addToBookedTickets($booking);
            //Redirect to bookings page
            $this->requestStack->getSession()->set(
                'success',
                "Booking created with reference {$booking->getReferenceNumber()}"
            );
            return $this->redirectToRoute('bookings');
        } catch (\Exception $exception) {
            $this->requestStack->getSession()->set('error', $exception->getMessage());
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