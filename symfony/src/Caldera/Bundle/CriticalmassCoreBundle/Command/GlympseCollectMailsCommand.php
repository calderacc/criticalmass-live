<?php

namespace Caldera\Bundle\CriticalmassCoreBundle\Command;

use Caldera\Bundle\CriticalmassCoreBundle\Statistic\RideEstimate\RideEstimateService;
use PhpImap\IncomingMail;
use PhpImap\Mailbox;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GlympseCollectMailsCommand extends ContainerAwareCommand
{
    /** @var Mailbox $mailbox */
    protected $mailbox;

    /** @var InputInterface $input */
    protected $input;

    /** @var OutputInterface $output */
    protected $output;

    protected function configure()
    {
        $this
            ->setName('criticalmass:glympse:collect-mails')
            ->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->connectMailbox();

        $unreadMails = $this->catchUnreadMails();

        foreach ($unreadMails as $unreadMail) {
            $this->grepInvitationCode($unreadMail);
        }
    }

    protected function connectMailbox()
    {
        $host = $this->getContainer()->getParameter('glympse.imap.hostname');
        $port = $this->getContainer()->getParameter('glympse.imap.port');
        $username = $this->getContainer()->getParameter('glympse.imap.username');
        $password = $this->getContainer()->getParameter('glympse.imap.password');

        $this->mailbox = new Mailbox('{'.$host.':'.$port.'/novalidate-cert/imap/ssl}INBOX', $username, $password);
    }

    protected function catchUnreadMails()
    {
        $unreadMailIds = $this->mailbox->searchMailbox('TO "hamburg@criticalmass.in"');
        $unreadMails = [];

        foreach ($unreadMailIds as $unreadMailId) {
            $unreadMails[$unreadMailId] = $this->mailbox->getMail($unreadMailId);
        }

        return $unreadMails;
    }

    protected function grepInvitationCode(IncomingMail $mail)
    {
        $plainBody = $mail->textPlain;

        preg_match('/([0-9A-Z]{4,4})\-([0-9A-Z]{4,4})/', $plainBody, $matches);

        $invitationCode = null;

        if ($matches && is_array($matches) && count($matches) == 3) {
            $invitationCode = $matches[0];
        }

        return $invitationCode;
    }
}