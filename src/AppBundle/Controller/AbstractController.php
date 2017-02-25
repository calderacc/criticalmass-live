<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ride;
use AppBundle\Repository\RideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

abstract class AbstractController extends Controller
{
    protected function getRideList(): array
    {
        return $this->getRideRepository()->findCurrentRides();
    }

    protected function getRideRepository(): RideRepository
    {
        return $this->getDoctrine()->getRepository('AppBundle:Ride');
    }
}