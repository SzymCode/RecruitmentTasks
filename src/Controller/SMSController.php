<?php

namespace App\Controller;

use App\Service\EmailService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SMSController extends AbstractController
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    #[Route("/fetch-sms")]
    public function fetchSMS(): Response
    {
        try {
            $this->emailService->fetchAndSaveSMS();

            return new Response('SMS fetched and saved successfully');
        } catch (Exception $e) {
            echo 'An error occurred: ' . $e->getMessage();
            return new Response($e->getMessage());
        }
    }
}
