<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"event:read"}},
 *     denormalizationContext={"groups"={"event:write"}},
 *     attributes={"filters"={"event.date_filter"}}
 * )
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
     * @Groups("event:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"event:read", "event:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     * @Groups({"event:read", "event:write"})
     */
    private $dateStartsAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"event:read", "event:write"})
     */
    private $dateEndsAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Groups({"event:read", "event:write"})
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"event:read", "event:write"})
     */
    private $organizedBy;

    /**
     * @Orm\OneToMany(targetEntity="App\Entity\Presentation", mappedBy="event")
     * @ApiSubresource
     */
    private $presentations;

    public function __construct()
    {
        $this->presentations = new ArrayCollection();
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

    public function getPresentations(): Collection
    {
        return $this->presentations;
    }

    public function setPresentations(ArrayCollection $presentations): void
    {
        $this->presentations = $presentations;
    }
}
