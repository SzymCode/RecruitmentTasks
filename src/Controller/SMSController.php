<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SMSController extends AbstractController
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     *  API Routes
     */
    #[Route("/api/sms/test")]
    public function testConnectionWithInfo(): JsonResponse | Response
    {
        return $this->emailService->testConnectionWithInfo();
    }
    #[Route("/api/sms")]
    public function fetchAllSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('ALL');
    }
    #[Route("/api/sms/unseen")]
    public function fetchUnseenSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('UNSEEN');
    }

    /**
     *  Render routes
     */
    #[Route("/sms/list")]
    public function listSMS(): Response
    {
        $smsList = $this->fetchAllSMS();

        return $this->render('sms/list.html.twig', [
            'smsList' => $smsList,
        ]);
    }
}
