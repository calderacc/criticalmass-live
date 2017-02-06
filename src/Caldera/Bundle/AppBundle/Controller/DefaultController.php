<?php

namespace AppBundle\Controller;

use Caldera\Bundle\CriticalmassSiteBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $this->getMetadata()
            ->setDescription('Live-Tracking für Critical-Mass-Touren');

        $startDateTime = new \DateTime();
        $startDateTime->sub(new \DateInterval('PT6H'));

        $endDateTime = new \DateTime();
        $endDateTime->add(new \DateInterval('P3D'));

        $rides = $this->getRideRepository()->findRidesAndCitiesInInterval($startDateTime, $endDateTime);
        $popularRides = $this->getRideRepository()->findPopularRides(15);

        return $this->render(
            'CalderaCriticalmassLiveBundle:Default:index.html.twig',
            [
                'rides' => $rides,
                'popularRides' => $popularRides
            ]
        );
    }
}
