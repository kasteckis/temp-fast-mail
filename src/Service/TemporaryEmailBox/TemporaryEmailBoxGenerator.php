<?php

namespace App\Service\TemporaryEmailBox;

use App\Repository\DomainRepository;
use App\Repository\TemporaryEmailBoxRepository;
use App\Service\Factory\TemporaryEmailBoxFactory;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory as FakerFactory;
use Faker\Generator;

class TemporaryEmailBoxGenerator
{
    private Generator $faker;

    public function __construct(
        private TemporaryEmailBoxRepository $temporaryEmailBoxRepository,
    ) {
        $this->faker = FakerFactory::create();
    }

    public function generateUniqueEmailAddress(string $domain): string
    {
        do {
            $localPart = $this->faker->unique()->userName;
            $emailAddress = $localPart . '.' .uniqid() .  '@' . $domain;
        } while ($this->temporaryEmailBoxRepository->findOneBy(['email' => $emailAddress]) !== null);

        return $emailAddress;
    }
}
