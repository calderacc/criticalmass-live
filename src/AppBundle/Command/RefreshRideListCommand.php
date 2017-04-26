<?php

namespace AppBundle\Command;

use AppBundle\Entity\City;
use AppBundle\Entity\Ride;
use Curl\Curl;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshRideListCommand extends ContainerAwareCommand
{
    /**
     * @var OutputInterface $output
     */
    protected $output;

    protected function configure()
    {
        $this
            ->setName('live:refresh:ride')
            ->setDescription('Store ride list')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serializer = $this->getContainer()->get('jms_serializer');

        /** @var EntityManager $manager */
        $manager = $this->getContainer()->get('doctrine')->getManager();

        $apiUrl = $this->getContainer()->getParameter('criticalmass.api');
        $apiUrl .= '/ride/list';

        $curl = new Curl();
        $curl->get($apiUrl);

        $jsonReponse = $curl->response;
        $rideList = json_decode($jsonReponse);

        $progress = new ProgressBar($output, count($rideList));
        $progress->start();

        foreach ($rideList as $json) {
            /** @var Ride $ride */
            $ride = $serializer->deserialize(json_encode($json), 'AppBundle\Entity\Ride', 'json');

            $this->fixDoubleSlugObjects($ride->getCity());

            if ($manager->getUnitOfWork()->isEntityScheduled($ride)) {
                $manager->merge($ride);
            } else {
                $manager->persist($ride);
            }

            $progress->advance();
        }

        $manager->flush();
    }

    /**
     * Yes, it is a fucking workaround.
     *
     * When jms deserializes, $city->mainSlug can contain an CitySlug object which is already going to persisted in
     * $city->slugs array. Doctrine does not understand the main slug to be one element of the slug list so it tries
     * to persist to slug objects which an identical id and fails.
     *
     * We save the id of the main slug here and replace it with one from the slug list so it is the same reference to
     * the same object.
     */
    protected function fixDoubleSlugObjects(City $city): void
    {
        $mainSlugId = $city->getMainSlug()->getId();

        $city->setMainSlug(null);

        foreach ($city->getSlugs() as $slug) {
            if ($slug->getId() === $mainSlugId) {
                $city->setMainSlug($slug);

                break;
            }
        }
    }
}
