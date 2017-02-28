<?php

namespace AppBundle\Controller;

use AppBundle\Manager\PositionManager;
use Caldera\GeoBasic\Bounds\Bounds;
use Caldera\GeoBasic\Coord\Coord;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method",
     *  parameters={
     *      {"name"="northWestLatitude", "dataType"="float", "required"=true, "description"=""},
     *      {"name"="northWestLongitude", "dataType"="float", "required"=true, "description"=""},
     *      {"name"="southEastLatitude", "dataType"="float", "required"=true, "description"=""},
     *      {"name"="southEastLongitude", "dataType"="float", "required"=true, "description"=""}
     *  }
     * )
     */
    public function getPositionsAction(Request $request)
    {
        $bounds = $this->getBoundsFromRequest($request);

        $positionList = $this->getPositionManager()->getPositionsInBounds($bounds);

        $view = View::create();
        $view
            ->setData($positionList)
            ->setFormat('json')
            ->setStatusCode(200);

        return $this->handleView($view);
    }

    protected function getPositionManager(): PositionManager
    {
        return $this->get('criticalmass.manager.position_manager');
    }

    protected function getBoundsFromRequest(Request $request): Bounds
    {
        if (
            !$request->query->get('northWestLatitude') ||
            !$request->query->get('northWestLongitude') ||
            !$request->query->get('southEastLatitude') ||
            !$request->query->get('southEastLongitude')
        ) {
            throw $this->createNotFoundException('wefwef');
        }

        $northWest = new Coord(
            $request->query->get('northWestLatitude'),
            $request->query->get('northWestLongitude')
        );

        $southEast = new Coord(
            $request->query->get('southEastLatitude'),
            $request->query->get('southEastLongitude')
        );

        return new Bounds($northWest, $southEast);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is a description of your API method"
     * )
     */
    public function getRidesAction(Request $request)
    {
        $rideList = $this->getDoctrine()->getRepository('AppBundle:Ride')->findCurrentRides();

        $view = View::create();
        $view
            ->setData($rideList)
            ->setFormat('json')
            ->setStatusCode(200);

        return $this->handleView($view);
    }
}
