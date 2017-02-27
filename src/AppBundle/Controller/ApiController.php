<?php

namespace AppBundle\Controller;

use AppBundle\Manager\PositionManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ApiController extends FOSRestController
{
    /**
     * This is the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method"
     * )
     */
    public function getPositionsAction(Request $request)
    {
        $view = View::create();
        $view
            ->setData(['lala'])
            ->setFormat('json')
            ->setStatusCode(200);

        return $this->handleView($view);
    }

    protected function getPositionManager(): PositionManager
    {
        return $this->get('criticalmass.manager.incident_manager');
    }
}
