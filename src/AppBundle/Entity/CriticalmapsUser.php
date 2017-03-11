<?php

namespace AppBundle\Entity;

use AppBundle\EntityInterface\LocationServiceInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table(name="criticalmaps_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CriticalmapsUserRepository")
 * @JMS\ExclusionPolicy("all")
 */
class CriticalmapsUser implements LocationServiceInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $identifier;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $creationDateTime;

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
     * @ORM\Column(type="datetime")
     */
    protected $startDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDateTime;

    public function __construct()
    {
        $this->creationDateTime = new \DateTime();
        $this->startDateTime = new \DateTime();
        $this->endDateTime = new \DateTime();
        
        $this->colorRed = rand(0, 255);
        $this->colorGreen = rand(0, 255);
        $this->colorBlue = rand(0, 255);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier): CriticalmapsUser
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getCreationDateTime(): \DateTime
    {
        return $this->creationDateTime;
    }

    public function setCreationDateTime($creationDateTime): CriticalmapsUser
    {
        $this->creationDateTime = $creationDateTime;

        return $this;
    }

    public function getColorRed(): int
    {
        return $this->colorRed;
    }

    public function setColorRed($colorRed): CriticalmapsUser
    {
        $this->colorRed = $colorRed;

        return $this;
    }

    public function getColorGreen(): int
    {
        return $this->colorGreen;
    }

    public function setColorGreen($colorGreen): CriticalmapsUser
    {
        $this->colorGreen = $colorGreen;

        return $this;
    }

    public function getColorBlue(): int
    {
        return $this->colorBlue;
    }

    public function setColorBlue($colorBlue): CriticalmapsUser
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

    public function setStartDateTime($startDateTime): CriticalmapsUser
    {
        $this->startDateTime = $startDateTime;

        return $this;
    }

    public function getEndDateTime(): ?\DateTime
    {
        return $this->endDateTime;
    }

    public function setEndDateTime($endDateTime): CriticalmapsUser
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function __toString(): string
    {
        return $this->identifier;
    }
}
