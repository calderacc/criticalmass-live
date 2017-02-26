<?php

namespace AppBundle\Controller;

use AppBundle\Entity\City;
use AppBundle\Entity\CitySlug;
use AppBundle\Repository\RideRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    protected function getCityBySlug(string $slug): City
    {
        /** @var CitySlug $citySlug */
        $citySlug = $this->getCitySlugRepository()->findOneBySlug($slug);

        if (!$citySlug) {
            throw $this->createNotFoundException();
        }

        $city = $citySlug->getCity();

        if (!$city) {
            throw $this->createNotFoundException();
        }

        return $city;
    }

    protected function getRideList(): array
    {
        return $this->getRideRepository()->findCurrentRides();
    }

    protected function getRideRepository(): RideRepository
    {
        return $this->getDoctrine()->getRepository('AppBundle:Ride');
    }

    protected function getCitySlugRepository(): ObjectRepository
    {
        return $this->getDoctrine()->getRepository('AppBundle:CitySlug');
    }
}