<?php

namespace App\Service\Handler\TemporaryEmailBox;

use App\Entity\TemporaryEmailBox;
use Doctrine\ORM\EntityManagerInterface;

class TemporaryEmailBoxUpdater
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function markAsLastAccessedNow(TemporaryEmailBox $temporaryEmailBox): void
    {
        $temporaryEmailBox->setLastAccessedAt(new \DateTimeImmutable());

        $this->entityManager->flush();
    }
}
