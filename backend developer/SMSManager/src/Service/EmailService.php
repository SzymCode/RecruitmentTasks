<?php

namespace App\Service;

use Exception;
use PhpImap\Mailbox;
use App\Entity\SMS;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmailService
{
    protected EntityManagerInterface $entityManager;
    private Mailbox $mailbox;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $server = $_ENV['IMAP_SERVER'];
        $port = $_ENV['IMAP_PORT'];
        $username = $_ENV['IMAP_USERNAME'];
        $password = $_ENV['IMAP_PASSWORD'];

        $mailboxPath = "{imap.$server:$port/imap/ssl}INBOX";

        if (!defined('OP_READONLY')) {
            define('OP_READONLY', 0);
        }

        $this->mailbox = new Mailbox($mailboxPath, $username, $password, null, 'UTF-8');
    }

    public function testConnectionWithInfo(): JsonResponse | Response
    {
        try {
            $mailboxInfo = $this->mailbox->getMailboxInfo();

            return new JsonResponse([
                'Connection' => 'OK',
                'Mailbox info' => $mailboxInfo
            ]);

        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage());
        }
    }

    public function fetchAndSaveSMS($criteria = null): JsonResponse | Response
    {
        try {
            $mailIds = $this->mailbox->searchMailbox($criteria);

            $mails = [];
            foreach ($mailIds as $mailId) {
                $mail = $this->mailbox->getMail($mailId);
                $header = $this->mailbox->getMailHeader($mailId);

                $mails[] = [
                    'sender' => $mail->fromAddress,
                    'receiver' => $header->toString,
                    'received_date' => date('Y-m-d H:i:s', strtotime($mail->date)),
                    'content' => $mail->textPlain
                ];

                $sms = new SMS();
                $sms->setSender($mail->fromAddress);
                $sms->setReceivedDate($mail->date);
                $sms->setContent($mail->textPlain);
                $this->entityManager->persist($sms);
            }

            $this->entityManager->flush();

            return new JsonResponse($mails);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
