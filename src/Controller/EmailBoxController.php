<?php

namespace App\Controller;

use App\DTO\Response\CreateEmailBoxResponseDto;
use App\Service\Handler\CreateEmailBoxHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmailBoxController extends AbstractController
{
    public function __construct(
        private CreateEmailBoxHandler $createEmailBoxHandler,
    ) {
    }

    #[Route('/api/email-box', name: 'app_email_box', methods: ['POST'])]
    public function createEmailBox(Request $request): Response
    {
        $creatorIp = $request->getClientIp() ?? 'unknown';

        $emailBox = $this->createEmailBoxHandler->create($creatorIp);

        return $this->json(CreateEmailBoxResponseDto::fromEntity($emailBox));
    }
}
