<?php

namespace App\Entity;

use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CinemaRepository::class)
 * @ORM\Table(name="cinemas")
 */
class Cinema
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
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Movie::class, mappedBy="cinema", orphanRemoval=true)
     */
    private $movies;

    /**
     * @ORM\OneToMany(targetEntity=Theatre::class, mappedBy="cinema", orphanRemoval=true)
     */
    private $theatres;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->theatres = new ArrayCollection();
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
            $movie->setCinema($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            // set the owning side to null (unless already changed)
            if ($movie->getCinema() === $this) {
                $movie->setCinema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Theatre[]
     */
    public function getTheatres(): Collection
    {
        return $this->theatres;
    }

    public function addTheatre(Theatre $theatre): self
    {
        if (!$this->theatres->contains($theatre)) {
            $this->theatres[] = $theatre;
            $theatre->setCinema($this);
        }

        return $this;
    }

    public function removeTheatre(Theatre $theatre): self
    {
        if ($this->theatres->removeElement($theatre)) {
            // set the owning side to null (unless already changed)
            if ($theatre->getCinema() === $this) {
                $theatre->setCinema(null);
            }
        }

        return $this;
    }
}
