<?php

namespace AppBundle\Entity;

use AppBundle\EntityInterface\LocationServiceInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table(name="position")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PositionRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Position
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose()
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
     * @JMS\Expose()
     * @JMS\SerializedName("creationDateTime")
     */
    protected $creationDateTime;

    public function __construct()
    {
        $this->creationDateTime = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setLatitude(float $latitude): Position
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLongitude(float $longitude): Position
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setAccuracy(float $accuracy = null): Position
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getAccuracy(): ?float
    {
        return $this->accuracy;
    }

    public function setAltitude(float $altitude = null): Position
    {
        $this->altitude = $altitude;

        return $this;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function setAltitudeAccuracy(float $altitudeAccuracy): Position
    {
        $this->altitudeAccuracy = $altitudeAccuracy;

        return $this;
    }

    public function getAltitudeAccuracy(): ?float
    {
        return $this->altitudeAccuracy;
    }

    public function setHeading(float $heading = null): Position
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): float
    {
        return $this->heading;
    }

    public function setSpeed(float $speed = null): Position
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setTimestamp(int $timestamp = null): Position
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setCreationDateTime(\DateTime $creationDateTime = null): Position
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getCreationDateTime(): ?\DateTime
    {
        return $this->creationDateTime;
    }
}
