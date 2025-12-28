<?php

namespace App\Service\Factory;

use App\Entity\TemporaryEmailBox;

class TemporaryEmailBoxFactory
{
    public function create(string $email, string $creatorIp): TemporaryEmailBox
    {
        $temporaryEmailBox = new TemporaryEmailBox();

        $temporaryEmailBox
            ->setEmail($email)
            ->setCreatorIp($creatorIp)
        ;

        return $temporaryEmailBox;
    }
}
