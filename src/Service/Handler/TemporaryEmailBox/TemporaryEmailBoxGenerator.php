<?php

namespace App\Service\Handler\TemporaryEmailBox;

use App\Repository\TemporaryEmailBoxRepository;
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

            $numbers = sprintf('%04d', random_int(0, 9999));

            $emailAddress = $localPart . '.' . $numbers .  '@' . $domain;
        } while ($this->temporaryEmailBoxRepository->findOneBy(['email' => $emailAddress]) !== null);

        return $emailAddress;
    }
}
