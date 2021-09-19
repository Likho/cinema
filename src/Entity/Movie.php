<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 * @ORM\Table(name="movies")
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $age_restriction;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Cinema::class, inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    /**
     * @ORM\OneToMany(targetEntity=MovieDate::class, mappedBy="movie", orphanRemoval=true)
     */
    private $movieDates;

    /**
     * @ORM\Column(type="integer")
     */
    private $cinema_id;

    /**
     * @ORM\ManyToOne(targetEntity=Theater::class, inversedBy="movies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theater;

    public function __construct()
    {
        $this->movieDates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAgeRestriction(): ?string
    {
        return $this->age_restriction;
    }

    public function setAgeRestriction(string $age_restriction): self
    {
        $this->age_restriction = $age_restriction;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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

    public function getCinema(): ?Cinema
    {
        return $this->cinema;
    }

    public function setCinema(?Cinema $cinema): self
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * @return Collection|MovieDate[]
     */
    public function getMovieDates(): Collection
    {
        return $this->movieDates;
    }

    public function addMovieDate(MovieDate $movieDate): self
    {
        if (!$this->movieDates->contains($movieDate)) {
            $this->movieDates[] = $movieDate;
            $movieDate->setMovie($this);
        }

        return $this;
    }

    public function removeMovieDate(MovieDate $movieDate): self
    {
        if ($this->movieDates->removeElement($movieDate)) {
            // set the owning side to null (unless already changed)
            if ($movieDate->getMovie() === $this) {
                $movieDate->setMovie(null);
            }
        }

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

    public function getTheater(): ?Theater
    {
        return $this->theater;
    }

    public function setTheater(?Theater $theater): self
    {
        $this->theater = $theater;

        return $this;
    }
}
