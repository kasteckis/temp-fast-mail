<?php

namespace App\Service\Handler\ReceivedEmail;

use App\Entity\ReceivedEmail;
use App\Repository\ReceivedEmailRepository;
use App\Repository\TemporaryEmailBoxRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

class ReceivedEmailsFetcher
{
    public function __construct(
        private TemporaryEmailBoxRepository $temporaryEmailBoxRepository,
        private ReceivedEmailRepository $receivedEmailRepository,
    ) {
    }

    /**
     * @param Uuid $uuid
     * @return ReceivedEmail[]
     */
    public function fetchByTemporaryEmailBoxUuid(Uuid $uuid): array
    {
        $emailBox = $this->temporaryEmailBoxRepository->findOneBy(['uuid' => $uuid]);

        if ($emailBox === null) {
            throw new NotFoundHttpException();
        }

        return $this->receivedEmailRepository->findBy(
            ['temporaryEmailBox' => $emailBox],
            ['createdAt' => 'DESC']
        );
    }

    public function findOneByTemporaryEmailBoxUuidAndReceivedEmailUuid(Uuid $temporaryEmailBoxUuid, Uuid $receivedEmailUuid): ReceivedEmail
    {
        $emailBox = $this->temporaryEmailBoxRepository->findOneBy(['uuid' => $temporaryEmailBoxUuid]);

        if ($emailBox === null) {
            throw new NotFoundHttpException();
        }

        $receivedEmail = $this->receivedEmailRepository->findOneBy([
            'uuid' => $receivedEmailUuid,
            'temporaryEmailBox' => $emailBox,
        ]);

        if ($receivedEmail === null) {
            throw new NotFoundHttpException();
        }

        return $receivedEmail;
    }
}
