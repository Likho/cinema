<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 * @ORM\Table(name="bookings")
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="integer")
     */
    private $movie_time_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number_of_tickets;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=MovieTime::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movieTime;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $reference_number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieTimeId(): ?int
    {
        return $this->movie_time_id;
    }

    public function setMovieTimeId(int $movie_time_id): self
    {
        $this->movie_time_id = $movie_time_id;

        return $this;
    }

    public function getNumberOfTickets(): ?int
    {
        return $this->number_of_tickets;
    }

    public function setNumberOfTickets(int $number_of_tickets): self
    {
        $this->number_of_tickets = $number_of_tickets;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMovieTime(): ?MovieTime
    {
        return $this->movieTime;
    }

    public function setMovieTime(?MovieTime $movieTime): self
    {
        $this->movieTime = $movieTime;

        return $this;
    }

    public function getReferenceNumber(): ?string
    {
        return $this->reference_number;
    }

    public function setReferenceNumber(string $reference_number): self
    {
        $this->reference_number = $reference_number;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
