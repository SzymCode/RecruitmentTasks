<?php

namespace App\Controller;

use App\Service\EmailService;
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

    #[Route("/api/sms")]
    public function fetchAllSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('ALL');
    }
    #[Route("/api/unseen-sms")]
    public function fetchUnseenSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('UNSEEN');
    }
}
