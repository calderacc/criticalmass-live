<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RideRepository extends EntityRepository
{
    public function findCurrentRides($order = 'ASC'): array
    {
        $startDateTime = new \DateTime();
        $startDateTimeInterval = new \DateInterval('P4W'); // four weeks ago
        $startDateTime->add($startDateTimeInterval);

        $endDateTime = new \DateTime();
        $endDateTimeInterval = new \DateInterval('P1W'); // one week after
        $endDateTime->sub($endDateTimeInterval);

        $builder = $this->createQueryBuilder('ride');

        $builder->select('ride');
        $builder->where($builder->expr()->lte('ride.dateTime', '\'' . $startDateTime->format('Y-m-d H:i:s') . '\''));
        $builder->andWhere($builder->expr()->gte('ride.dateTime', '\'' . $endDateTime->format('Y-m-d H:i:s') . '\''));

        $builder->orderBy('ride.dateTime', $order);

        $query = $builder->getQuery();

        return $query->getResult();
    }
}
