<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

class PositionRepository extends EntityRepository
{
    public function findCurrentPositions(\DateInterval $interval): array
    {
        $dateTime = new \DateTime();
        $dateTime->sub($interval);

        $qb = $this->createQueryBuilder('p');

        $qb
            ->where($qb->expr()->gte('p.creationDateTime', ':dateTime'))
            ->addGroupBy('p.glympseTicket')
            ->setParameter('dateTime', $dateTime->format('Y-m-d H:i:s'))
        ;

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
