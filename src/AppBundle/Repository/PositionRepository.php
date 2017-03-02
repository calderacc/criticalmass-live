<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class PositionRepository extends EntityRepository
{
    public function findCurrentPositions(): array
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->addGroupBy('p.glympseTicket')
            ->addGroupBy('p.criticalmapsUser')
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
