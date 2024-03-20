<?php

namespace App\Service;

use Exception;
use PhpImap\Mailbox;
use App\Entity\SMS;
use Doctrine\ORM\EntityManagerInterface;

class EmailService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function fetchAndSaveSMS(): void
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

            $criteria = 'UNSEEN';

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
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
        }
    }

}
