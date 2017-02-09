<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 */
class CitySlug
{
    /**
     * @JMS\Expose
     */
    protected $id;

    /**
     * @JMS\Expose
     */
    protected $slug;

    /**
     */
    protected $city;

    /**
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    public function __toString()
    {
        return $this->getSlug();
    }

    /**
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
