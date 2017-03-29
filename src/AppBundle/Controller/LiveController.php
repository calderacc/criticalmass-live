<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Ride;
use Symfony\Component\HttpFoundation\Request;

class LiveController extends AbstractController
{
    public function cityAction(Request $request, $citySlug)
    {
        $city = $this->getCityBySlug($citySlug);

        /** @var Ride $ride */
        $ride = $this->getRideRepository()->findCurrentRideForCity($city);

        return $this->render(
            'AppBundle:Default:live.html.twig',
            [
                'ride' => $ride,
                'city' => $city,
            ]
        );
    }
}
