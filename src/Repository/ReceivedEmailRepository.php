<?php

namespace App\Repository;

use App\Entity\ReceivedEmail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReceivedEmail>
 */
class ReceivedEmailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReceivedEmail::class);
    }

    public function deleteOlderThan24Hours(\DateTimeImmutable $cutoffDate): int
    {
        return $this->createQueryBuilder('r')
            ->delete()
            ->where('r.createdAt < :cutoffDate')
            ->setParameter('cutoffDate', $cutoffDate)
            ->getQuery()
            ->execute();
    }
}
