<?php

namespace AppBundle\Repository;

use AppBundle\Entity\City;
use AppBundle\Entity\Ride;
use Doctrine\ORM\EntityRepository;

class RideRepository extends EntityRepository
{
    public function findCurrentRides($order = 'ASC'): array
    {

}
