<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $rides = $this->getRideList();

        $ride = array_pop($rides);

        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'rides' => $rides,
            ]
        );
    }
}
