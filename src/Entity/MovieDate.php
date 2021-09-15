<?php

namespace App\Entity;

use App\Repository\MovieDateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieDateRepository::class)
 * @ORM\Table(name="movie_dates")
 */
class MovieDate
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
    private $movie_id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="movieDates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    /**
     * @ORM\OneToMany(targetEntity=MovieTime::class, mappedBy="movieDate", orphanRemoval=true)
     */
    private $movieTimes;

    public function __construct()
    {
        $this->movieTimes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieId(): ?int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

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
            $movieTime->setMovieDate($this);
        }

        return $this;
    }

    public function removeMovieTime(MovieTime $movieTime): self
    {
        if ($this->movieTimes->removeElement($movieTime)) {
            // set the owning side to null (unless already changed)
            if ($movieTime->getMovieDate() === $this) {
                $movieTime->setMovieDate(null);
            }
        }

        return $this;
    }
}
