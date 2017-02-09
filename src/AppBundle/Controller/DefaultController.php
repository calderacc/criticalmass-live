<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $rides = $this->getRideList();

        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'rides' => $rides,
                'popularRides' => $popularRides
            ]
        );
    }
}
