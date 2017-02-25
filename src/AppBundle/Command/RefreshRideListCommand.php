<?php

namespace AppBundle\Command;

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
        $manager = $this->getContainer()->get('doctrine')->getEntityManager();

        $apiUrl = $this->getContainer()->getParameter('criticalmass.api');
        $apiUrl .= '/ride/list';

        $curl = new Curl();
        $curl->get($apiUrl);

        $jsonReponse = $curl->response;
        $rideList = json_decode($jsonReponse);

        $progress = new ProgressBar($output, count($rideList));
        $progress->start();

        foreach ($rideList as $json) {
            $ride = $serializer->deserialize(json_encode($json), 'AppBundle\Entity\Ride', 'json');

            var_dump($json, $ride);
            $manager->persist($ride);

            $progress->advance();
            die;
        }

        $manager->flush();
    }
}
