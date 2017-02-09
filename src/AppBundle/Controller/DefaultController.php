<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $startDateTime = new \DateTime();
        $startDateTime->sub(new \DateInterval('PT6H'));

        $endDateTime = new \DateTime();
        $endDateTime->add(new \DateInterval('P3D'));

        $rides = $this->getRideRepository()->findRidesAndCitiesInInterval($startDateTime, $endDateTime);
        $popularRides = $this->getRideRepository()->findPopularRides(15);

        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'rides' => $rides,
                'popularRides' => $popularRides
            ]
        );
    }
}
