<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(attributes={"filters"={"event.date_filter"}})
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ApiFilter(SearchFilter::class, properties={"id": "exact", "name": "partial", "location": "partial", "organizedBy": "partial"})
 * @ApiFilter(OrderFilter::class, properties={"id", "name", "dateStartsAt"}, arguments={"orderParameterName"="order"})
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
    private $dateStartsAt;

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

    public function getDateStartsAt(): ?\DateTimeInterface
    {
        return $this->dateStartsAt;
    }

    public function setDateStartsAt(\DateTimeInterface $dateStartsAt): self
    {
        $this->dateStartsAt = $dateStartsAt;

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
