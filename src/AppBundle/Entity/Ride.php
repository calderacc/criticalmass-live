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
     * @JMS\Type("DateTime")
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
     * @ORM\Column(type="float")
     * @JMS\Groups({"ride-list"})
     * @JMS\Expose
     * @JMS\SerializedName("latitude")
     * @JMS\Type("float")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
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

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set date
     *
     * @param \DateTime $dateTime
     * @return Ride
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function getSimpleDate()
    {
        return $this->dateTime->format('Y-m-d');
    }

    /**
     * Set hasTime
     *
     * @param boolean $hasTime
     * @return Ride
     */
    public function setHasTime(bool $hasTime)
    {
        $this->hasTime = $hasTime;

        return $this;
    }

    /**
     * Get hasTime
     *
     * @return boolean
     */
    public function getHasTime()
    {
        return $this->hasTime;
    }

    /**
     * Set hasLocation
     *
     * @param boolean $hasLocation
     * @return Ride
     */
    public function setHasLocation($hasLocation)
    {
        $this->hasLocation = $hasLocation;

        return $this;
    }

    /**
     * Get hasLocation
     *
     * @return boolean
     */
    public function getHasLocation()
    {
        return $this->hasLocation;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Ride
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set city
     *
     * @param City $city
     * @return Ride
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Ride
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Ride
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isEqual(Ride $ride)
    {
        return $ride->getId() == $this->getId();
    }

    public function equals(Ride $ride)
    {
        return $this->isEqual($ride);
    }

    public function isSameRide(Ride $ride)
    {
        return $ride->getCity()->getId() == $this->getCity()->getId() && $ride->getFormattedDate() == $this->getFormattedDate();
    }

    public function __toString()
    {
        if ($this->city) {
            return $this->city->getTitle() . " - " . $this->getDateTime()->format("Y-m-d");
        } else {
            return $this->getDateTime()->format("Y-m-d");
        }
    }

    public function __construct()
    {
        $this->dateTime = new \DateTime();
        $this->createdAt = new \DateTime();
        $this->visibleSince = new \DateTime();
        $this->visibleUntil = new \DateTime();
        $this->expectedStartDateTime = new \DateTime();
        $this->archiveDateTime = new \DateTime();
        $this->latitude = 0.0;
        $this->longitude = 0.0;
    }

    /**
     * Set estimatedParticipants
     *
     * @param integer $estimatedParticipants
     * @return Ride
     */
    public function setEstimatedParticipants($estimatedParticipants)
    {
        $this->estimatedParticipants = $estimatedParticipants;

        return $this;
    }

    /**
     * Get estimatedParticipants
     *
     * @return integer
     */
    public function getEstimatedParticipants()
    {
        return $this->estimatedParticipants;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return Ride
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return Ride
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Ride
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("timestamp")
     * @JMS\Type("integer")
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->dateTime->format('U');
    }


    public function getFormattedDate()
    {
        return $this->dateTime->format('Y-m-d');
    }

    public function getDate()
    {
        return $this->dateTime;
    }

    public function getTime()
    {
        return $this->dateTime;
    }

    public function setDate(\DateTime $date)
    {
        $this->dateTime = new \DateTime($date->format('Y-m-d') . ' ' . $this->dateTime->format('H:i:s'), $date->getTimezone());
    }

    public function setTime(\DateTime $time)
    {
        $this->dateTime = new \DateTime($this->dateTime->format('Y-m-d') . ' ' . $time->format('H:i:s'), $time->getTimezone());
    }

    /**
     * Set estimatedDistance
     *
     * @param float $estimatedDistance
     * @return Ride
     */
    public function setEstimatedDistance($estimatedDistance)
    {
        $this->estimatedDistance = $estimatedDistance;

        return $this;
    }

    /**
     * Get estimatedDistance
     *
     * @return float
     */
    public function getEstimatedDistance()
    {
        return $this->estimatedDistance;
    }

    /**
     * Set estimatedDuration
     *
     * @param float $estimatedDuration
     * @return Ride
     */
    public function setEstimatedDuration($estimatedDuration)
    {
        $this->estimatedDuration = $estimatedDuration;

        return $this;
    }

    /**
     * Get estimatedDuration
     *
     * @return float
     */
    public function getEstimatedDuration()
    {
        return $this->estimatedDuration;
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdated(date('Y-m-d H:i:s'));
    }

    /**
     * @JMS\VirtualProperty
     * @JMS\SerializedName("title")
     * @JMS\Type("string")
     * @return string
     */
    public function getFancyTitle()
    {
        if (!$this->title) {
            return $this->city->getTitle() . ' ' . $this->dateTime->format('d.m.Y');
        }

        return $this->getTitle();
    }

    /**
     * Set isArchived
     *
     * @param boolean $isArchived
     * @return Ride
     */
    public function setIsArchived(bool $isArchived)
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    /**
     * Get isArchived
     *
     * @return boolean
     */
    public function getIsArchived()
    {
        return $this->isArchived;
    }

    /**
     * Set archiveDateTime
     *
     * @param \DateTime $archiveDateTime
     * @return Ride
     */
    public function setArchiveDateTime(\DateTime $archiveDateTime)
    {
        $this->archiveDateTime = $archiveDateTime;

        return $this;
    }

    public function getPin(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set participationsNumberYes
     *
     * @param integer $participationsNumberYes
     * @return Ride
     */
    public function setParticipationsNumberYes($participationsNumberYes)
    {
        $this->participationsNumberYes = $participationsNumberYes;

        return $this;
    }

    /**
     * Get participationsNumberYes
     *
     * @return integer
     */
    public function getParticipationsNumberYes()
    {
        return $this->participationsNumberYes;
    }

    /**
     * Set participationsNumberMaybe
     *
     * @param integer $participationsNumberMaybe
     * @return Ride
     */
    public function setParticipationsNumberMaybe($participationsNumberMaybe)
    {
        $this->participationsNumberMaybe = $participationsNumberMaybe;

        return $this;
    }

    /**
     * Get participationsNumberMaybe
     *
     * @return integer
     */
    public function getParticipationsNumberMaybe()
    {
        return $this->participationsNumberMaybe;
    }

    /**
     * Set participationsNumberNo
     *
     * @param integer $participationsNumberNo
     * @return Ride
     */
    public function setParticipationsNumberNo($participationsNumberNo)
    {
        $this->participationsNumberNo = $participationsNumberNo;

        return $this;
    }

    /**
     * Get participationsNumberNo
     *
     * @return integer
     */
    public function getParticipationsNumberNo()
    {
        return $this->participationsNumberNo;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function incViews()
    {
        ++$this->views;
    }

    public function getCountry()
    {
        if ($this->city) {
            return $this->city->getCountry();
        }

        return null;
    }

    public function getIsEnabled()
    {
        if ($this->city) {
            return $this->city->isEnabled();
        }

        return null;
    }
}
