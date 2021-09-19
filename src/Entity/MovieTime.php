<?php

namespace App\Entity;

use App\Repository\MovieTimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieTimeRepository::class)
 * @ORM\Table(name="movie_times")
 */
class MovieTime
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=MovieDate::class, inversedBy="movieTimes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movieDate;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Theater::class, inversedBy="movieTimes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theater;

    /**
     * @ORM\Column(type="integer")
     */
    private $tickets_booked;

    /**
     * @ORM\Column(type="integer")
     */
    private $theater_id;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="movieTime", orphanRemoval=true)
     */
    private $bookings;

    /**
     * @ORM\Column(type="integer")
     */
    private $movie_date_id;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getMovieDate(): ?MovieDate
    {
        return $this->movieDate;
    }

    public function setMovieDate(?MovieDate $movieDate): self
    {
        $this->movieDate = $movieDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getTheater(): ?Theater
    {
        return $this->theater;
    }

    public function setTheater(?Theater $theater): self
    {
        $this->theater = $theater;

        return $this;
    }

    public function getTicketsBooked(): ?int
    {
        return $this->tickets_booked;
    }

    public function setTicketsBooked(int $tickets_booked): self
    {
        $this->tickets_booked = $tickets_booked;

        return $this;
    }

    public function getTheaterId(): ?int
    {
        return $this->theater_id;
    }

    public function setTheaterId(int $theater_id): self
    {
        $this->theater_id = $theater_id;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setMovieTime($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getMovieTime() === $this) {
                $booking->setMovieTime(null);
            }
        }

        return $this;
    }

    public function getMovieDateId(): ?int
    {
        return $this->movie_date_id;
    }

    public function setMovieDateId(int $movie_date_id): self
    {
        $this->movie_date_id = $movie_date_id;

        return $this;
    }
}
