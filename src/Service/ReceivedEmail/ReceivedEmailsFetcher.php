<?php

namespace App\Service\ReceivedEmail;

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
}
