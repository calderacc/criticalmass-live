<?php

namespace AppBundle\Controller;

use AppBundle\Manager\PositionManager;
use Caldera\GeoBasic\Bounds\Bounds;
use Caldera\GeoBasic\Coord\Coord;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

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
    public function getPositionsAction(Request $request): Response
    {
        $bounds = $this->getBoundsFromRequest($request);

        if ($bounds) {
            $positionList = $this->getPositionManager()->getCurrentPositionsInBounds($bounds);

            $view = View::create();
            $view
                ->setData($positionList)
                ->setFormat('json')
                ->setStatusCode(200);

            return $this->handleView($view);
        } else {
            $response = $this->getCachedResponse();

            if (!$response) {
                $positionList = $this->getPositionManager()->getCurrentPositions();

                $view = View::create();
                $view
                    ->setData($positionList)
                    ->setFormat('json')
                    ->setStatusCode(200);

                $response = $this->handleView($view);

                $this->cacheResponse($response);
            }

            return $response;
        }
    }

    protected function getPositionManager(): PositionManager
    {
        return $this->get('criticalmass.manager.position_manager');
    }

    protected function getBoundsFromRequest(Request $request): ?Bounds
    {
        if (
            !$request->query->get('northWestLatitude') ||
            !$request->query->get('northWestLongitude') ||
            !$request->query->get('southEastLatitude') ||
            !$request->query->get('southEastLongitude')
        ) {
            return null;
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
    public function getRidesAction(Request $request): Response
    {
        $rideList = $this->getDoctrine()->getRepository('AppBundle:Ride')->findCurrentRides();

        $view = View::create();
        $view
            ->setData($rideList)
            ->setFormat('json')
            ->setStatusCode(200);

        return $this->handleView($view);
    }

    protected function getCache(): AbstractAdapter
    {
        $redisConnection = RedisAdapter::createConnection('redis://localhost');
        $cache = new RedisAdapter(
            $redisConnection,
            $namespace = 'criticalmass-live',
            $defaultLifetime = 0
        );

        return $cache;
    }

    protected function cacheResponse(Response $response): void
    {
        $expireInterval = new \DateInterval('PT20S');

        $cache = $this->getCache();

        $cacheItem = $cache->getItem('response-cache');

        $cacheItem->set($response);
        $cacheItem->expiresAfter($expireInterval);

        $cache->save($cacheItem);
    }

    protected function getCachedResponse(): ?Response
    {
        $cache = $this->getCache();

        $cacheItem = $cache->getItem('response-cache');

        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        return null;
    }
}
