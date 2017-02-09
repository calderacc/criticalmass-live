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
     * @JMS\Type("integer")
     */
    protected $id;

    /**
     * @JMS\Expose
     * @JMS\Type("string")
     */
    protected $slug;

    public function getId(): int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): CitySlug
    {
        $this->slug = $slug;

        return $this;
    }
}
