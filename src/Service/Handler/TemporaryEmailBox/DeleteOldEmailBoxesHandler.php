<?php

namespace App\Service\Handler\TemporaryEmailBox;

use App\Entity\TemporaryEmailBox;
use App\Repository\TemporaryEmailBoxRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeleteOldEmailBoxesHandler
{
    public function __construct(
        private TemporaryEmailBoxRepository $temporaryEmailBoxRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function deleteOlderThan(\DateTimeImmutable $olderThan): int
    {
        /** @var TemporaryEmailBox[] $temporaryEmailBoxes */
        $temporaryEmailBoxes = $this->temporaryEmailBoxRepository->findOlderThan($olderThan);
        $deletedInboxCount = 0;

        foreach ($temporaryEmailBoxes as $temporaryEmailBox) {
            if ($temporaryEmailBox->getReceivedEmails()->isEmpty()) {
                $this->entityManager->remove($temporaryEmailBox);
                $deletedInboxCount++;
            }
        }

        $this->entityManager->flush();

        return $deletedInboxCount;
    }
}
