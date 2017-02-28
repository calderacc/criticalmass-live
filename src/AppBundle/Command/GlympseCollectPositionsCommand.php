<?php

namespace AppBundle\Command;

use AppBundle\Entity\GlympseTicket;
use AppBundle\Entity\Position;
use AppBundle\Glympse\Exception\GlympseApiBrokenException;
use AppBundle\Glympse\Exception\GlympseApiErrorException;
use AppBundle\Glympse\Exception\GlympseException;
use AppBundle\Glympse\Exception\GlympseInviteUnknownException;
use Curl\Curl;
use Doctrine\ORM\EntityManager;
use PhpImap\Mailbox;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GlympseCollectPositionsCommand extends ContainerAwareCommand
{
    /** @var Mailbox $mailbox */
    protected $mailbox;

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
            ->setName('live:positions:glympse')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->manager = $this->getContainer()->get('doctrine')->getManager();

        $this->accessToken = $this->getAccessToken();

        $tickets = $this->getTicketsToQuery();

        /** @var GlympseTicket $ticket */
        foreach ($tickets as $ticket) {
            $this->output->writeln(sprintf('Query ticket <info>#%d</info>', $ticket->getId()));

            try {
                $this->saveNewPositions($ticket);
            } catch (GlympseException $exception) {
                $this->output->writeln($exception->getMessage());
            }
        }
        
        $this->manager->flush();
    }

    protected function getAccessToken()
    {
        $hostname = $this->getContainer()->getParameter('glympse.api.hostname');
        $key = $this->getContainer()->getParameter('glympse.api.key');
        $username = $this->getContainer()->getParameter('glympse.api.username');
        $password = $this->getContainer()->getParameter('glympse.api.password');

        $loginUrl = $hostname . '/account/login';

        $curl = new Curl();

        try {
            $curl->get($loginUrl, [
                'api_key' => $key,
                'id' => $username,
                'password' => $password,
            ]);
        } catch (\Exception $exception) {
            throw new GlympseApiBrokenException($curl->error_message);
        }

        $response = json_decode($curl->response);

        if (!$response || isset($response->error)) {
            throw new GlympseApiBrokenException($curl->error_message);
        }

        if ($response->result == 'failure') {
            throw new GlympseApiErrorException($response->meta->error_detail);
        }

        $accessToken = null;

        if ($response->response->access_token) {
            $accessToken = $response->response->access_token;
        }

        return $accessToken;

    }

    protected function getTicketsToQuery()
    {
        return $this->manager->getRepository('AppBundle:GlympseTicket')->findBy(
            ['endDateTime' => null]
        );
    }

    protected function saveNewPositions(GlympseTicket $ticket)
    {
        $queryResult = $this->queryTicket($ticket);

        if (isset($queryResult->location) && $queryResult->location) {
            $positionList = $this->extractPositionList($queryResult->location);

            $this->output->writeln(sprintf('Found <comment>%d</comment> positions to track', count($positionList)));

            $this->persistPositionList($positionList, $ticket);
        } else {
            $this->output->writeln(sprintf('Did not find any positions to track'));
        }

        $ticket->setCounter($queryResult->next);
    }

    protected function queryTicket(GlympseTicket $ticket)
    {
        $hostname = $this->getContainer()->getParameter('glympse.api.hostname');

        $invitesUrl = $hostname . '/v2/invites/' . $ticket->getInviteId();

        $curl = new Curl();

        try {
            $queryData = [
                'oauth_token' => $this->accessToken,
                'properties' => 'true',
                'next' => $ticket->getCounter(),
            ];

            $curl->get($invitesUrl, $queryData);
        } catch (\Exception $exception) {
            throw new GlympseApiBrokenException($curl->error_message);
        }

        $response = json_decode($curl->response);

        if (!$response || isset($response->error)) {
            throw new GlympseApiBrokenException($curl->error_message);
        }

        if ($response->result == 'failure' && $response->meta->error == 'invite_code') {
            $ticket->setEndDateTime(new \DateTime());

            throw new GlympseInviteUnknownException($response->meta->error_detail);
        } elseif ($response->result == 'failure') {
            $ticket->setEndDateTime(new \DateTime());

            throw new GlympseApiErrorException($response->meta->error_detail);
        }

        return $response->response;
    }

    protected function extractPositionList(array $locations = []): array
    {
        $positionList = [];

        $currentLocation = null;

        $currentLatitude = null;
        $currentLongitude = null;

        foreach ($locations as $location) {
            if (!$currentLocation) {
                $currentLocation = $location;
            } else {
                foreach ($location as $key => $value) {
                    $currentLocation[$key] += $value;
                }
            }

            $position = new Position();
            $position
                ->setLatitude($currentLocation[1] / 1000000)
                ->setLongitude($currentLocation[2] / 1000000)
            ;

            $positionList[] = $position;
        }

        return $positionList;
    }

    protected function persistPositionList(array $positionList, GlympseTicket $ticket)
    {
        /** @var Position $position */
        foreach ($positionList as $position) {
            $position->setGlympseTicket($ticket);

            $this->manager->persist($position);
        }
    }
}
