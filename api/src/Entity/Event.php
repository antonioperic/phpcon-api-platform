<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $dateStartAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEndsAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organizedBy;

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

    public function getDateStartAt(): ?\DateTimeInterface
    {
        return $this->dateStartAt;
    }

    public function setDateStartAt(\DateTimeInterface $dateStartAt): self
    {
        $this->dateStartAt = $dateStartAt;

        return $this;
    }

    public function getDateEndsAt(): ?\DateTimeInterface
    {
        return $this->dateEndsAt;
    }

    public function setDateEndsAt(?\DateTimeInterface $dateEndsAt): self
    {
        $this->dateEndsAt = $dateEndsAt;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOrganizedBy(): ?string
    {
        return $this->organizedBy;
    }

    public function setOrganizedBy(?string $organizedBy): self
    {
        $this->organizedBy = $organizedBy;

        return $this;
    }
}
