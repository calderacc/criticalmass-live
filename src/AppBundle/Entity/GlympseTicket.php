<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CriticalmapsUserRepository")
 * @ORM\Table(name="glympse_ticket")
 * @JMS\ExclusionPolicy("all")
 */
class GlympseTicket
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

    public function __construct()
    {

    }

    public function getId()
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

    public function getInviteId()
    {
        return $this->inviteId;
    }

    public function setInviteId($inviteId)
    {
        $this->inviteId = $inviteId;

        return $this;
    }

    public function getCounter()
    {
        return $this->counter;
    }

    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    public function increaseCounter(int $increasement = 1)
    {
        $this->counter += $increasement;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function getColorRed()
    {
        return $this->colorRed;
    }

    public function setColorRed($colorRed)
    {
        $this->colorRed = $colorRed;

        return $this;
    }

    public function getColorGreen()
    {
        return $this->colorGreen;
    }

    public function setColorGreen($colorGreen)
    {
        $this->colorGreen = $colorGreen;

        return $this;
    }

    public function getColorBlue()
    {
        return $this->colorBlue;
    }

    public function setColorBlue($colorBlue)
    {
        $this->colorBlue = $colorBlue;

        return $this;
    }

    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    public function setStartDateTime($startDateTime)
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    public function setCreationDateTime(\DateTime $creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getQueried(): bool
    {
        return $this->queried;
    }

    public function setQueried(bool $queried)
    {
        $this->queried = $queried;

        return $this;
    }

    public function __toString(): string
    {
        return $this->inviteId;
    }
}
