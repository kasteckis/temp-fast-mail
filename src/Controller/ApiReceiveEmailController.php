<?php

namespace App\Controller;

use App\DTO\Request\CreateEmailRequestDto;
use App\Service\Handler\CreateReceivedEmailHandler;
use App\Service\Validator\ReceivedEmail\CreateReceivedEmailAuthValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class ApiReceiveEmailController extends AbstractController
{
    public function __construct(
        private CreateReceivedEmailAuthValidator $createReceivedEmailAuthValidator,
        private CreateReceivedEmailHandler $createReceivedEmailHandler,
    ) {
    }

    #[Route('/api/email', name: 'api_create_email', methods: ['POST'])]
    public function createEmail(
        Request $request,
        #[MapRequestPayload] CreateEmailRequestDto $createEmailRequestDto,
    ): Response
    {
        $this->createReceivedEmailAuthValidator->validate($request);
        $this->createReceivedEmailHandler->create($createEmailRequestDto);

        return $this->json('OK', Response::HTTP_CREATED);
    }
}
