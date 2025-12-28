<?php

namespace App\Service\Handler;

use App\Entity\TemporaryEmailBox;
use App\Repository\DomainRepository;
use App\Repository\TemporaryEmailBoxRepository;
use App\Service\Factory\TemporaryEmailBoxFactory;
use App\Service\TemporaryEmailBox\TemporaryEmailBoxGenerator;
use Doctrine\ORM\EntityManagerInterface;

class CreateEmailBoxHandler
{
    public function __construct(
        private DomainRepository $domainRepository,
        private TemporaryEmailBoxFactory $emailBoxFactory,
        private EntityManagerInterface $entityManager,
        private TemporaryEmailBoxGenerator $temporaryEmailBoxGenerator,
    ) {
    }

    public function create(string $creatorIp): TemporaryEmailBox
    {
        $domain = $this->domainRepository->findOneActiveRandomDomain();
        $emailAddress = $this->temporaryEmailBoxGenerator->generateUniqueEmailAddress($domain->getDomain());

        $emailBox = $this->emailBoxFactory->create($emailAddress, $creatorIp);

        $this->entityManager->persist($emailBox);
        $this->entityManager->flush();

        return $emailBox;
    }
}
