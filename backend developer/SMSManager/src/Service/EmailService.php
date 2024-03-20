<?php

namespace App\Service;

use Exception;
use PhpImap\Mailbox;
use App\Entity\SMS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class EmailService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function fetchAndSaveSMS($criteria = null): Response
    {
        try {
            $server = $_ENV['IMAP_SERVER'];
            $port = $_ENV['IMAP_PORT'];
            $username = $_ENV['IMAP_USERNAME'];
            $password = $_ENV['IMAP_PASSWORD'];

            $mailboxPath = "{imap.$server:$port/imap/ssl}INBOX";

            if (!defined('OP_READONLY')) {
                define('OP_READONLY', 0);
            }

            $mailbox = new Mailbox($mailboxPath, $username, $password, null, 'UTF-8');

            $mailIds = $mailbox->searchMailbox($criteria);

            foreach ($mailIds as $mailId) {
                $mail = $mailbox->getMail($mailId);

                $sms = new SMS();
                $sms->setSender($mail->fromAddress);
                $sms->setReceivedDate($mail->date);
                $sms->setContent($mail->textPlain);

                $this->entityManager->persist($sms);
            }

            $this->entityManager->flush();

            return new Response('Fetched SMS data successfully!');
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage());
        }
    }

}
