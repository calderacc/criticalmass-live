<?php

namespace AppBundle\Manager;

use Caldera\GeoBasic\Bounds\Bounds;
use Doctrine\Common\Persistence\ObjectRepository;

class PositionManager extends AbstractElasticManager
{
    /** @var ObjectRepository $positionRepository */
    protected $positionRepository = null;

    public function __construct($doctrine, $elasticIndex)
    {
        parent::__construct($doctrine, $elasticIndex);

        $this->positionRepository = $this->doctrine->getRepository('AppBundle:Position');
    }

    public function getCurrentPositionsInBounds(Bounds $bounds): array
    {
        $boundingBoxFilter = new \Elastica\Filter\GeoBoundingBox('pin', $bounds->toLatLonArray());

        $filteredQuery = new \Elastica\Query\Filtered(new \Elastica\Query\MatchAll(), $boundingBoxFilter);

        $query = new \Elastica\Query($filteredQuery);

        $query->setSize(500);

        $result = $this->elasticManager->getRepository('AppBundle:Position')->find($query);

        return $result;
    }

    public function getCurrentPositions(): array
    {
        $matchAll = new \Elastica\Query\Filtered(new \Elastica\Query\MatchAll());

        $query = new \Elastica\Query($matchAll);

        $query->setSize(500);

        $result = $this->elasticManager->getRepository('AppBundle:Position')->find($query);

        return $result;
    }
}