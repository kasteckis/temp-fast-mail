<?php

namespace App\Service\Handler\ReceivedEmail;

use App\DTO\Request\CreateEmailRequestDto;
use App\Entity\ReceivedEmail;
use App\Service\Factory\ReceivedEmailFactory;
use Doctrine\ORM\EntityManagerInterface;

class CreateReceivedEmailHandler
{
    public function __construct(
        private ReceivedEmailFactory $receivedEmailFactory,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function create(CreateEmailRequestDto $createEmailRequestDto): ReceivedEmail
    {
        $receivedEmail = $this->receivedEmailFactory->createFromDto($createEmailRequestDto);

        $this->entityManager->persist($receivedEmail);
        $this->entityManager->flush();

        return $receivedEmail;
    }
}
