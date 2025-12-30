<?php

namespace App\Controller;

use App\DTO\Response\CreateEmailBoxResponseDto;
use App\DTO\Response\ReceivedEmailResponseDto;
use App\DTO\Response\ReceivedEmailResponseListDto;
use App\Service\Client\ClientIpRetriever;
use App\Service\Handler\CreateEmailBoxHandler;
use App\Service\ReceivedEmail\ReceivedEmailsFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

final class EmailBoxController extends AbstractController
{
    public function __construct(
        private CreateEmailBoxHandler $createEmailBoxHandler,
        private ReceivedEmailsFetcher $receivedEmailsFetcher,
        private ClientIpRetriever $clientIpRetriever,
    ) {
    }

    #[Route('/api/email-box', name: 'api_create_email_box', methods: ['POST'])]
    public function createEmailBox(Request $request): Response
    {
        $creatorIp = $this->clientIpRetriever->getClientIp($request);

        $emailBox = $this->createEmailBoxHandler->create($creatorIp);

        return $this->json(CreateEmailBoxResponseDto::fromEntity($emailBox));
    }

    #[Route('/api/email-box/{emailBoxUuid}/emails', name: 'api_get_email_box_messages', methods: ['GET'])]
    public function getEmailBoxByUuid(Uuid $emailBoxUuid): Response
    {
        $receivedEmails = $this->receivedEmailsFetcher->fetchByTemporaryEmailBoxUuid($emailBoxUuid);

        $receivedEmailsResponseDtos = array_map(
            fn ($receivedEmail) => ReceivedEmailResponseListDto::fromEntity($receivedEmail),
            $receivedEmails
        );

        return $this->json($receivedEmailsResponseDtos);
    }

    #[Route('/api/email-box/{emailBoxUuid}/email/{emailUuid}', name: 'api_get_email_box_one_message', methods: ['GET'])]
    public function getOneReceivedEmailMessage(Uuid $emailBoxUuid, Uuid $emailUuid): Response
    {
        return $this->json(
            ReceivedEmailResponseDto::fromEntity(
                $this->receivedEmailsFetcher->findOneByTemporaryEmailBoxUuidAndReceivedEmailUuid($emailBoxUuid, $emailUuid)
            )
        );
    }

    #[Route('/email-box/{emailBoxUuid}/email/{emailUuid}', name: 'api_view_email_box_one_message', methods: ['GET'])]
    public function viewOneReceivedEmailMessage(Uuid $emailBoxUuid, Uuid $emailUuid): Response
    {
        $receivedEmail = $this->receivedEmailsFetcher->findOneByTemporaryEmailBoxUuidAndReceivedEmailUuid($emailBoxUuid, $emailUuid);

        return $this->render('email_box/view.html.twig', [
            'receivedEmail' => $receivedEmail,
        ]);
    }
}
