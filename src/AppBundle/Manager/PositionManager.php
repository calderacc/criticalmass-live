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

    public function getPositionsInBounds(Bounds $bounds, array $knownIndizes = []): array
    {
        $filterList = [];
        $filterList[] = new \Elastica\Filter\GeoBoundingBox('pin', $bounds->toLatLonArray());

        $knownIndexFilters = [];

        foreach ($knownIndizes as $knownIndex) {
            $knownIndexFilters[] = new \Elastica\Filter\Term(['id' => $knownIndex]);
        }

        if (count($knownIndexFilters)) {
            $filterList[] = new \Elastica\Filter\BoolNot(new \Elastica\Filter\BoolOr($knownIndexFilters));

        }

        $andFilter = new \Elastica\Filter\BoolAnd($filterList);

        $filteredQuery = new \Elastica\Query\Filtered(new \Elastica\Query\MatchAll(), $andFilter);

        $query = new \Elastica\Query($filteredQuery);

        $query->setSize(500);

        $result = $this->elasticManager->getRepository('AppBundle:Position')->find($query);

        return $result;
    }
}