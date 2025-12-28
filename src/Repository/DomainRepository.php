<?php

namespace App\Repository;

use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Domain>
 */
class DomainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    public function countOfActiveDomains(): int
    {
        $now = new \DateTimeImmutable();

        return (int) $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->andWhere('d.activeUntil >= :now')
            ->setParameter('now', $now)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findOneActiveRandomDomain(): ?Domain
    {
        $now = new \DateTimeImmutable();
        $count = $this->countOfActiveDomains();
        $randomOffset = rand(0, $count - 1);

        return $this->createQueryBuilder('d')
            ->andWhere('d.activeUntil >= :now')
            ->setParameter('now', $now)
            ->setMaxResults(1)
            ->setFirstResult($randomOffset)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
