<?php

namespace App\Service;

use DateTime;
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
            ], Response::HTTP_OK);

        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
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
                    'id' => $mail->id,
                    'sender' => $mail->fromAddress,
                    'receiver' => $header->toString,
                    'received_date' => date('Y-m-d H:i:s', strtotime($mail->date)),
                    'subject' => $mail->subject,
                    'content' => $mail->textPlain
                ];

                $sms = new SMS();
                $sms->setSender($mail->fromAddress);
                $sms->setReceiver($header->toString);
                $sms->setReceivedDate($mail->date);
                $sms->setSubject($mail->subject);
                $sms->setContent($mail->textPlain);

                $this->entityManager->persist($sms);
            }

            $this->entityManager->flush();

            return new JsonResponse($mails, Response::HTTP_OK);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     *  Save
     */
    public function saveSMS(string $sender, string $receiver, string $subject = null, string $content = null): Response
    {
        try {
            $sms = new SMS();
            $sms->setSender($sender);
            $sms->setReceiver($receiver);
            $sms->setReceivedDate((new DateTime())->format('Y-m-d H:i:s'));
            $sms->setSubject($subject);
            $sms->setContent($content);

            $this->entityManager->persist($sms);
            $this->entityManager->flush();

            return new Response('SMS created successfully.', Response::HTTP_OK);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     *  Update
     */
    public function updateSMS(int $id, string $sender, string $receiver, string $subject = null, string $content = null): Response
    {
        try {
            $sms = $this->entityManager->getRepository(SMS::class)->find($id);
            if (!$sms) {
                return new Response('SMS not found.', Response::HTTP_NOT_FOUND);
            }

            $sms->setSender($sender);
            $sms->setReceiver($receiver);
            if ($subject !== null) {
                $sms->setSubject($subject);
            }
            if ($content !== null) {
                $sms->setContent($content);
            }

            $this->entityManager->flush();

            return new Response('SMS updated successfully.', Response::HTTP_OK);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     *  Delete
     */
    public function deleteSMS(int $id): Response
    {
        try {
            $this->mailbox->deleteMail($id);

            return new Response('SMS deleted successfully.', Response::HTTP_OK);
        } catch (Exception $e) {
            return new Response('An error occurred: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
