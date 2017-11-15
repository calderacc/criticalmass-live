<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table(name="ride")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RideRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Ride
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="NONE")
     * @JMS\Expose
     * @JMS\SerializedName("id")
     * @JMS\Groups({"ride-list"})
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="rides", cascade={"persist"}, fetch="LAZY")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @JMS\Groups({"ride-list"})
     * @JMS\SerializedName("city")
     * @JMS\Expose
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("title")
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("description")
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\Type("DateTime<'U'>")
     * @JMS\SerializedName("dateTime")
     */
    protected $dateTime;

    /**
     * @ORM\Column(type="boolean")
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\Type("boolean")
     * @JMS\SerializedName("hasTime")
     */
    protected $hasTime;

    /**
     * @ORM\Column(type="boolean")
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("hasLocation")
     * @JMS\Type("boolean")
     */
    protected $hasLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("location")
     * @JMS\Type("string")
     */
    protected $location;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("latitude")
     * @JMS\Type("float")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("longitude")
     * @JMS\Type("float")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("estimatedParticipants")
     * @JMS\Type("integer")
     */
    protected $estimatedParticipants;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("estimatedDistance")
     * @JMS\Type("float")
     */
    protected $estimatedDistance;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("estimatedDuration")
     * @JMS\Type("float")
     */
    protected $estimatedDuration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("facebook")
     * @JMS\Type("string")
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("twitter")
     * @JMS\Type("string")
     */
    protected $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("url")
     * @JMS\Type("string")
     */
    protected $url;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\SerializedName("participationsNumberYes")
     * @JMS\Type("integer")
     */
    protected $participationsNumberYes = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\SerializedName("participationsNumberMaybe")
     * @JMS\Type("integer")
     */
    protected $participationsNumberMaybe = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     * @JMS\SerializedName("participationsNumberNo")
     * @JMS\Type("integer")
     */
    protected $participationsNumberNo = 0;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Ride
    {
        $this->id = $id;

        return $this;
    }

    public function setDateTime(\DateTime $dateTime): Ride
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setHasTime(bool $hasTime): Ride
    {
        $this->hasTime = $hasTime;

        return $this;
    }

    public function getHasTime(): bool
    {
        return $this->hasTime;
    }

    public function setHasLocation(bool $hasLocation): Ride
    {
        $this->hasLocation = $hasLocation;

        return $this;
    }

    public function getHasLocation(): bool
    {
        return $this->hasLocation;
    }

    public function setLocation(string $location): Ride
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setCity(City $city = null): Ride
    {
        $this->city = $city;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setLatitude(float $latitude): Ride
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLongitude(float $longitude = null): Ride
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setTitle(string $title = null): Ride
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description = null): Ride
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function __toString()
    {
        if ($this->city) {
            return $this->city->getTitle() . " - " . $this->getDateTime()->format("Y-m-d");
        } else {
            return $this->getDateTime()->format("Y-m-d");
        }
    }

    public function setFacebook(string $facebook = null): Ride
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setTwitter(string $twitter = null): Ride
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setUrl(string $url = null): Ride
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getPin(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): Ride
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
