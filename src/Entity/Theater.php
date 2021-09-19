<?php

namespace App\Entity;

use App\Repository\TheaterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TheaterRepository::class)
 * @ORM\Table(name="theaters")
 */
class Theater
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $cinema_id;

    /**
     * @ORM\ManyToOne(targetEntity=Cinema::class, inversedBy="theaters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_seats;

    /**
     * @ORM\OneToMany(targetEntity=MovieTime::class, mappedBy="theater", orphanRemoval=true)
     */
    private $movieTimes;

    /**
     * @ORM\OneToMany(targetEntity=Movie::class, mappedBy="theater", orphanRemoval=true)
     */
    private $movies;

    public function __construct()
    {
        $this->movieTimes = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCinemaId(): ?int
    {
        return $this->cinema_id;
    }

    public function setCinemaId(int $cinema_id): self
    {
        $this->cinema_id = $cinema_id;

        return $this;
    }

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }

    public function getMaxSeats(): ?int
    {
        return $this->max_seats;
    }

    public function setMaxSeats(int $max_seats): self
    {
        $this->max_seats = $max_seats;

        return $this;
    }

    /**
     * @return Collection|MovieTime[]
     */
    public function getMovieTimes(): Collection
    {
        return $this->movieTimes;
    }

    public function addMovieTime(MovieTime $movieTime): self
    {
        if (!$this->movieTimes->contains($movieTime)) {
            $this->movieTimes[] = $movieTime;
            $movieTime->setTheater($this);
        }

        return $this;
    }

    public function removeMovieTime(MovieTime $movieTime): self
    {
        if ($this->movieTimes->removeElement($movieTime)) {
            // set the owning side to null (unless already changed)
            if ($movieTime->getTheater() === $this) {
                $movieTime->setTheater(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->setTheater($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getTheater() === $this) {
                $movie->setTheater(null);
            }
        }

        return $this;
    }
}
