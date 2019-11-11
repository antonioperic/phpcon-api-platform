<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"presentation:read"}},
 *     denormalizationContext={"groups"={"presentation:write"}},
 *     subresourceOperations={
 *         "api_events_presentations_get_subresource"={
 *             "method"="GET",
 *             "normalization_context"={"groups"={"event:read:presentation"}}
 *        }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PresentationRepository")
 */
class Presentation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"presentation:read", "presentation:write", "event:read:presentation"})
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Groups({"presentation:read", "presentation:write", "event:read:presentation"})
     */
    private $startsAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="presentations")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"presentation:read", "presentation:write"})
     */
    private $event;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     * @Groups("presentation:read")
     */
    private $averageRating = 0;

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

    public function getStartsAt(): ?string
    {
        return $this->startsAt;
    }

    public function setStartsAt(?string $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getAverageRating(): ?string
    {
        return $this->averageRating;
    }

    public function setAverageRating(string $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }
}
