<?php

namespace AppBundle\Repository;

use AppBundle\Entity\City;
use AppBundle\Entity\Ride;
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

        $builder
            ->select('ride')
            ->join('ride.city', 'city')
            ->where($builder->expr()->lte('ride.dateTime', '\'' . $startDateTime->format('Y-m-d H:i:s') . '\''))
            ->andWhere($builder->expr()->gte('ride.dateTime', '\'' . $endDateTime->format('Y-m-d H:i:s') . '\''))
        ;

        $builder->orderBy('city.name', $order);

        $query = $builder->getQuery();

        return $query->getResult();
    }

    public function findCurrentRideForCity(City $city): Ride
    {
        $builder = $this->createQueryBuilder('ride');

        $builder->select('ride');

        $builder->where($builder->expr()->eq('ride.city', $city->getId()));

        $builder->addOrderBy('ride.dateTime', 'ASC');

        $builder->setMaxResults(1);

        $query = $builder->getQuery();

        return $query->getOneOrNullResult();
    }
}
