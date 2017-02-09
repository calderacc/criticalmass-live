<?php

namespace AppBundle\Command;

use Curl\Curl;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshRideListCommand extends ContainerAwareCommand
{
    /**
     * @var EntityManager $manager
     */
    protected $manager;

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
        $apiUrl = $this->getContainer()->getParameter('criticalmass.api');
        $apiUrl .= '/ride/list';

        $curl = new Curl();
        $curl->get($apiUrl);

        $jsonReponse = $curl->response;
        $rideList = json_decode($jsonReponse);

        $entityList = [];

        $progress = new ProgressBar($output, count($rideList));
        $progress->start();

        foreach ($rideList as $ride) {
            $entityList[] = json_encode($ride);
            $progress->advance();
        }

        $cache = new FilesystemAdapter();

        $cacheItem = $cache->getItem('ride-list');
        $cacheItem->set($entityList);
        $cache->save($cacheItem);

        $progress->finish();
    }
}
