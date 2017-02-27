<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="position")
 * @ORM\Entity()
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="GlympseTicket", inversedBy="positions")
     * @ORM\JoinColumn(name="glympse_ticket_id", referencedColumnName="id")
     */
    protected $glympseTicket;

    /**
     * @ORM\ManyToOne(targetEntity="CriticalmapsUser", inversedBy="positions")
     * @ORM\JoinColumn(name="criticalmaps_user", referencedColumnName="id")
     */
    protected $criticalmapsUser;

    /**
     * @ORM\Column(type="float")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $accuracy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $altitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $altitudeAccuracy;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $heading;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $speed;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $creationDateTime;

    public function __construct()
    {
        $this->creationDateTime = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getAccuracy()
    {
        return $this->accuracy;
    }

    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function setAltitudeAccuracy($altitudeAccuracy)
    {
        $this->altitudeAccuracy = $altitudeAccuracy;

        return $this;
    }

    public function getAltitudeAccuracy()
    {
        return $this->altitudeAccuracy;
    }

    public function setHeading($heading)
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading()
    {
        return $this->heading;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setCreationDateTime($creationDateTime)
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getCreationDateTime()
    {
        return $this->creationDateTime;
    }

    public function setGlympseTicket(GlympseTicket $glympseTicket = null)
    {
        $this->glympseTicket = $glympseTicket;

        return $this;
    }

    public function getGlympseTicket()
    {
        return $this->glympseTicket;
    }

    public function setCriticalmapsUser(CriticalmapsUser $criticalmapsUser)
    {
        $this->criticalmapsUser = $criticalmapsUser;

        return $this;
    }

    public function getCriticalmapsUser()
    {
        return $this->criticalmapsUser;
    }

    public function getPin(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }
}
