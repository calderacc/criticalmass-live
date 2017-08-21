<?php

namespace AppBundle\Command;

use AppBundle\Entity\CriticalmapsUser;
use AppBundle\Entity\Position;
use AppBundle\Entity\Ride;
use Curl\Curl;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CriticalmapsCollectPositionsCommand extends ContainerAwareCommand
{
    /** @var InputInterface $input */
    protected $input;

    /** @var OutputInterface $output */
    protected $output;

    /** @var EntityManager $manager */
    protected $manager;

    /** @var string $accessToken */
    protected $accessToken;

    protected function configure()
    {
        $this
            ->setName('live:positions:criticalmaps')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->manager = $this->getContainer()->get('doctrine')->getManager();

        $locations = $this->fetchLocations();

        $this->savePositions($locations);

        $this->manager->flush();
    }

    protected function fetchLocations()
    {
        $curl = new Curl();
        $curl->get($this->getContainer()->getParameter('criticalmaps.api'));

        $result = json_decode($curl->response);

        $locations = $result->locations;

        return $locations;
    }

    protected function savePositions($locations)
    {
        foreach ($locations as $identifier => $location) {
            $position = $this->convertLocationToPosition($location);

            $criticalmapsUser = $this->findCriticalmapsUserForIdentifier($identifier);

            if (!$criticalmapsUser) {
                $criticalmapsUser = $this->createNewCriticalmapsUser($identifier);

            }

            $criticalmapsUser->setEndDateTime(new \DateTime());
            $position->setCriticalmapsUser($criticalmapsUser);

            $this->manager->persist($criticalmapsUser);
            $this->manager->persist($position);

            $this->output->writeln(sprintf(
                'Position [<info>%f</info>, <info>%f</info>] saved for <comment>%s</comment>',
                $position->getLatitude(),
                $position->getLongitude(),
                $criticalmapsUser->getIdentifier()
            ));
        }
    }

    protected function convertLocationToPosition($location): Position
    {
        $latitude = $location->latitude / 1000000;
        $longitude = $location->longitude / 1000000;
        $timestamp = $location->timestamp;
        $dateTime = new \DateTime();

        $position = new Position();
        $position
            ->setLatitude($latitude)
            ->setLongitude($longitude)
            ->setTimestamp($timestamp)
            ->setCreationDateTime($dateTime);

        return $position;
    }

    protected function findRideForPosition(Position $position)
    {
        $dateTime = new \DateTime();

        $finder = $this->getContainer()->get('fos_elastica.finder.criticalmass.ride');

        $geoFilter = new \Elastica\Filter\GeoDistance(
            'pin',
            [
                'lat' => $position->getLatitude(),
                'lon' => $position->getLongitude()
            ],
            '30km'
        );

        $dateTimeFilter = new \Elastica\Filter\Term(['simpleDate' => $dateTime->format('Y-m-d')]);

        $filter = new \Elastica\Filter\BoolAnd([$geoFilter, $dateTimeFilter]);

        $filteredQuery = new \Elastica\Query\Filtered(new \Elastica\Query\MatchAll(), $filter);

        $query = new \Elastica\Query($filteredQuery);

        $query->setSize(1);
        $query->setSort(
            [
                '_geo_distance' =>
                    [
                        'pin' =>
                            [
                                $position->getLongitude(),
                                $position->getLatitude()
                            ],
                        'order' => 'asc',
                        'unit' => 'km'
                    ]
            ]
        );

        $results = $finder->find($query);

        return array_pop($results);
    }

    protected function findCriticalmapsUserForIdentifier(string $identifier)
    {
        /** @var CriticalmapsUser $criticalmapsUser */
        $criticalmapsUser = $this->manager->getRepository('AppBundle:CriticalmapsUser')->findOneByIdentifier($identifier);

        return $criticalmapsUser;
    }

    protected function createNewCriticalmapsUser(string $identifier): CriticalmapsUser
    {
        $criticalmapsUser = new CriticalmapsUser();

        $criticalmapsUser
            ->setIdentifier($identifier);

        return $criticalmapsUser;
    }
}