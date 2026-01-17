<?php

namespace App\Service\Handler\TemporaryEmailBox;

use App\Entity\TemporaryEmailBox;
use App\Repository\TemporaryEmailBoxRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Uid\Uuid;

class TemporaryEmailBoxFetcher
{
    public function __construct(
        private TemporaryEmailBoxRepository $temporaryEmailBoxRepository,
    ) {
    }

    public function fetchByUuid(Uuid $uuid): TemporaryEmailBox
    {
        $temporaryEmailBox = $this->temporaryEmailBoxRepository->findOneBy(['uuid' => $uuid]);

        if ($temporaryEmailBox === null) {
            throw new NotFoundHttpException();
        }

        return $temporaryEmailBox;
    }
}
