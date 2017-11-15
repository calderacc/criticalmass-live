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
     * @ORM\GeneratedValue(strategy="NONE")
     * @JMS\Expose
     * @JMS\SerializedName("id")
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="CitySlug", inversedBy="cities", cascade={"merge"}, fetch="LAZY")
     * @ORM\JoinColumn(name="main_slug_id", referencedColumnName="id")
     * @JMS\Expose
     * @JMS\SerializedName("mainSlug")
     * @JMS\Type("AppBundle\Entity\CitySlug")
     * @JMS\Accessor(setter="setMainSlug")
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
     * @JMS\Accessor(setter="setSlugs")
     */
    protected $slugs;

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

    public function setId($id): City
    {
        $this->id = $id;

        return $this;
    }

    public function getMainSlug(): ?CitySlug
    {
        return $this->mainSlug;
    }

    public function setMainSlug(CitySlug $citySlug = null): City
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

        $slug->setCity($this);

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
    
    public function setSlugs(Collection $slugs): City
    {
        foreach ($slugs as $slug) {
            $slug->setCity($this);
        }

        $this->slugs = $slugs;
        
        return $this;
    }

    public function setDescription(string $description = null): City
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setPunchLine(string $punchLine = null): City
    {
        $this->punchLine = $punchLine;

        return $this;
    }

    public function getPunchLine(): ?string
    {
        return $this->punchLine;
    }

    public function setLongDescription(string $longDescription = null): City
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function setImageName(string $imageName = null): City
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getPin(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }

    public function setTimezone(string $timezone = 'Europe/Berlin'): City
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setColorRed(int $colorRed): City
    {
        $this->colorRed = $colorRed;

        return $this;
    }

    public function getColorRed(): int
    {
        return $this->colorRed;
    }

    public function setColorGreen(int $colorGreen): City
    {
        $this->colorGreen = $colorGreen;

        return $this;
    }

    public function getColorGreen(): int
    {
        return $this->colorGreen;
    }

    public function setColorBlue(int $colorBlue): City
    {
        $this->colorBlue = $colorBlue;

        return $this;
    }

    public function getColorBlue(): int
    {
        return $this->colorBlue;
    }
}
