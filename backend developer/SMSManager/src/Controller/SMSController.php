<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route("/api/sms/test", methods: 'GET')]
    public function testConnectionWithInfo(): JsonResponse | Response
    {
        return $this->emailService->testConnectionWithInfo();
    }
    #[Route("/api/sms", methods: 'GET')]
    public function fetchAllSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('ALL');
    }
    #[Route("/api/sms/unseen", methods: 'GET')]
    public function fetchUnseenSMS(): Response
    {
        return $this->emailService->fetchAndSaveSMS('UNSEEN');
    }

    /**
     *  Other CRUD routes
     */
    #[Route("/sms", methods: 'GET')]
    public function listSMS(): Response
    {
        $smsList = $this->fetchAllSMS();

        return $this->render('sms/list.html.twig', [
            'smsList' => $smsList,
        ]);
    }

    #[Route("/sms", methods: 'POST')]
    public function saveSMS(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $sender = $data['sender'] ?? null;
        $receiver = $data['receiver'] ?? null;
        $subject = $data['subject'] ?? null;
        $content = $data['content'] ?? null;

        if (!$sender || !$receiver) {
            return new JsonResponse(['error' => 'Missing required data.'], Response::HTTP_BAD_REQUEST);
        }

        return $this->emailService->saveSMS($sender, $receiver, $subject, $content);
    }


    #[Route("/sms/{id}", methods: 'PUT')]
    public function updateSMS(Request $request, int $id): JsonResponse | Response
    {
        $data = json_decode($request->getContent(), true);

        $sender = $data['sender'] ?? null;
        $receiver = $data['receiver'] ?? null;
        $subject = $data['subject'] ?? null;
        $content = $data['content'] ?? null;

        if (!$sender || !$receiver) {
            return new JsonResponse(['error' => 'Missing required data.'], Response::HTTP_BAD_REQUEST);
        }

        return $this->emailService->updateSMS($id, $sender, $receiver, $subject, $content);
    }

    #[Route("/sms/{id}", methods: 'DELETE')]
    public function deleteSMS(int $id): Response
    {
        return $this->emailService->deleteSMS($id);
    }
}
