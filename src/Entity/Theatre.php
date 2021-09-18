<?php

namespace App\Entity;

use App\Repository\TheatreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TheatreRepository::class)
 */
class Theatre
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
     * @ORM\ManyToOne(targetEntity=Cinema::class, inversedBy="theatres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cinema;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_seats;

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
}
