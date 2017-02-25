<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity()
 * @ORM\Table(name="city")
 * @JMS\ExclusionPolicy("all")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose
     * @JMS\SerializedName("id")
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @JMS\Expose
     * @JMS\SerializedName("mainSlug")
     * @JMS\Type("AppBundle\Entity\CitySlug")
     */
    protected $mainSlug;

    /**
     * @ORM\Column(type="string", length=50)
     * @JMS\Expose
     * @JMS\SerializedName("name")
     * @JMS\Type("string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @JMS\Expose
     * @JMS\SerializedName("title")
     * @JMS\Type("string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("description")
     * @JMS\Type("string")
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("url")
     * @JMS\Type("string")
     */
    protected $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("facebook")
     * @JMS\Type("string")
     */
    protected $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Expose
     * @JMS\SerializedName("twitter")
     * @JMS\Type("string")
     */
    protected $twitter;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose
     * @JMS\SerializedName("latitude")
     * @JMS\Type("float")
     */
    protected $latitude = 0.0;

    /**
     * @ORM\Column(type="float")
     * @JMS\Expose
     * @JMS\SerializedName("longitude")
     * @JMS\Type("float")
     */
    protected $longitude = 0.0;

    /**
     * @ORM\OneToMany(targetEntity="CitySlug", mappedBy="city", cascade={"persist", "remove"})
     * @JMS\Expose
     * @JMS\SerializedName("slugs")
     * @JMS\Type("ArrayCollection<AppBundle\Entity\CitySlug>")
     */
    protected $slugs;

    /**
     * @ORM\Column(type="boolean")
     * @JMS\SerializedName("isStandardable")
     * @JMS\Expose
     */
    protected $isStandardable = false;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @JMS\SerializedName("standardDayOfWeek")
     * @JMS\Expose
     */
    protected $standardDayOfWeek;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @JMS\Expose
     */
    protected $standardWeekOfMonth;

    /**
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    protected $isStandardableTime = false;

    /**
     * @ORM\Column(type="time", nullable=true)
     * @JMS\Expose
     */
    protected $standardTime;

    /**
     * @ORM\Column(type="boolean")
     * @JMS\Expose
     */
    protected $isStandardableLocation = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     */
    protected $standardLocation;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Expose
     */
    protected $standardLatitude = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @JMS\Expose
     */
    protected $standardLongitude = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @JMS\Expose
     */
    protected $cityPopulation = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @JMS\Expose
     */
    protected $punchLine;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Expose
     */
    protected $longDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;


    /**
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $timezone;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     */
    protected $threadNumber = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     */
    protected $postNumber = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     */
    protected $colorRed = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     */
    protected $colorGreen = 0;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Expose
     */
    protected $colorBlue = 0;

    /**
     * @ORM\Column(type="integer")
     */
    protected $views = 0;

    public function __construct()
    {
        $this->slugs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainSlug(): CitySlug
    {
        return $this->mainSlug;
    }

    public function setMainSlug(CitySlug $citySlug): City
    {
        $this->mainSlug = $citySlug;

        return $this;
    }

    public function getMainSlugString(): string
    {
        return $this->getMainSlug()->getSlug();
    }

    public function getSlug(): string
    {
        return $this->getMainSlugString();
    }

    public function setName(string $name): City
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setTitle(string $title): City
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setUrl(string $url): City
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setFacebook(string $facebook): City
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setTwitter($twitter): City
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getTwitter(): string
    {
        return $this->twitter;
    }

    public function setLatitude(float $latitude): City
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLongitude(float $longitude): City
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function addSlug(CitySlug $slug): City
    {
        if (!$this->mainSlug) {
            $this->mainSlug = $slug;
        }

        $this->slugs->add($slug);

        return $this;
    }

    public function removeSlug(CitySlug $slugs): City
    {
        $this->slugs->removeElement($slugs);

        return $this;
    }

    public function getSlugs(): Collection
    {
        return $this->slugs;
    }

    public function setDescription(string $description): City
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setIsStandardable(bool $isStandardable): City
    {
        $this->isStandardable = $isStandardable;

        return $this;
    }

    public function getIsStandardable(): bool
    {
        return $this->isStandardable;
    }

    public function setStandardDayOfWeek($standardDayOfWeek)
    {
        $this->standardDayOfWeek = $standardDayOfWeek;

        return $this;
    }

    public function getStandardDayOfWeek()
    {
        return $this->standardDayOfWeek;
    }

    public function setStandardWeekOfMonth($standardWeekOfMonth)
    {
        $this->standardWeekOfMonth = $standardWeekOfMonth;

        return $this;
    }

    public function getStandardWeekOfMonth()
    {
        return $this->standardWeekOfMonth;
    }

    public function setStandardTime($standardTime)
    {
        $this->standardTime = $standardTime;

        return $this;
    }

    public function getStandardTime()
    {
        return $this->standardTime;
    }

    public function setStandardLocation($standardLocation)
    {
        $this->standardLocation = $standardLocation;

        return $this;
    }

    public function getStandardLocation()
    {
        return $this->standardLocation;
    }

    public function setStandardLatitude($standardLatitude)
    {
        $this->standardLatitude = $standardLatitude;

        return $this;
    }

    public function getStandardLatitude()
    {
        return $this->standardLatitude;
    }

    public function setStandardLongitude($standardLongitude)
    {
        $this->standardLongitude = $standardLongitude;

        return $this;
    }

    public function getStandardLongitude()
    {
        return $this->standardLongitude;
    }

    public function setCityPopulation($cityPopulation)
    {
        $this->cityPopulation = $cityPopulation;

        return $this;
    }

    public function getCityPopulation()
    {
        return $this->cityPopulation;
    }

    public function setPunchLine($punchLine)
    {
        $this->punchLine = $punchLine;

        return $this;
    }

    public function getPunchLine()
    {
        return $this->punchLine;
    }

    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getLongDescription()
    {
        return $this->longDescription;
    }

    public function setIsArchived(bool $isArchived)
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function setIsStandardableLocation($isStandardableLocation)
    {
        $this->isStandardableLocation = $isStandardableLocation;

        return $this;
    }

    public function getIsStandardableLocation()
    {
        return $this->isStandardableLocation;
    }

    public function setIsStandardableTime($isStandardableTime)
    {
        $this->isStandardableTime = $isStandardableTime;

        return $this;
    }

    public function getIsStandardableTime()
    {
        return $this->isStandardableTime;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function getPin(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone()
    {
        return $this->timezone;
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

    public function setColorRed($colorRed)
    {
        $this->colorRed = $colorRed;

        return $this;
    }

    public function getColorRed()
    {
        return $this->colorRed;
    }

    public function setColorGreen($colorGreen)
    {
        $this->colorGreen = $colorGreen;

        return $this;
    }

    public function getColorGreen()
    {
        return $this->colorGreen;
    }

    public function setColorBlue($colorBlue)
    {
        $this->colorBlue = $colorBlue;

        return $this;
    }

    public function getColorBlue()
    {
        return $this->colorBlue;
    }
}
