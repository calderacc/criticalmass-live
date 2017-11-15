<?php

namespace AppBundle\Entity;

use AppBundle\EntityInterface\LocationServiceInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CriticalmapsUserRepository")
 * @ORM\Table(name="glympse_ticket")
 * @JMS\ExclusionPolicy("all")
 */
class GlympseTicket implements LocationServiceInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="glympse_tickets")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=9, nullable=false)
     */
    protected $inviteId;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $creationDateTime;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $counter = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $username;

    /**
     * @ORM\Column(type="smallint")
     * @JMS\Expose()
     */
    protected $colorRed = 0;

    /**
     * @ORM\Column(type="smallint")
     * @JMS\Expose()
     */
    protected $colorGreen = 0;

    /**
     * @ORM\Column(type="smallint")
     * @JMS\Expose()
     */
    protected $colorBlue = 0;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $startDateTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $endDateTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $message;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $active = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $queried = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setCity(City $city): GlympseTicket
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getInviteId(): string
    {
        return $this->inviteId;
    }

    public function setInviteId(string $inviteId): GlympseTicket
    {
        $this->inviteId = $inviteId;

        return $this;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): GlympseTicket
    {
        $this->counter = $counter;

        return $this;
    }

    public function increaseCounter(int $increasement = 1): GlympseTicket
    {
        $this->counter += $increasement;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): GlympseTicket
    {
        $this->username = $username;

        return $this;
    }

    public function getColorRed(): int
    {
        return $this->colorRed;
    }

    public function setColorRed(string $colorRed): GlympseTicket
    {
        $this->colorRed = $colorRed;

        return $this;
    }

    public function getColorGreen(): int
    {
        return $this->colorGreen;
    }

    public function setColorGreen(string $colorGreen): GlympseTicket
    {
        $this->colorGreen = $colorGreen;

        return $this;
    }

    public function getColorBlue(): int
    {
        return $this->colorBlue;
    }

    public function setColorBlue(string $colorBlue): GlympseTicket
    {
        $this->colorBlue = $colorBlue;

        return $this;
    }

    public function getRgbColor(): array
    {
        return [
            'red' => $this->colorRed,
            'green' => $this->colorGreen,
            'blue' => $this->colorBlue
        ];
    }

    public function getStartDateTime(): \DateTime
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(\DateTime $startDateTime): GlympseTicket
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): \DateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime(\DateTime $endDateTime): GlympseTicket
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): GlympseTicket
    {
        $this->active = $active;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): GlympseTicket
    {
        $this->message = $message;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName = null): GlympseTicket
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getCreationDateTime(): \DateTime
    {
        return $this->creationDateTime;
    }

    public function setCreationDateTime(\DateTime $creationDateTime): GlympseTicket
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getQueried(): bool
    {
        return $this->queried;
    }

    public function setQueried(bool $queried): GlympseTicket
    {
        $this->queried = $queried;

        return $this;
    }

    public function getName(): string
    {
        return 'glympse';
    }

    public function __toString(): string
    {
        return $this->inviteId;
    }
}
