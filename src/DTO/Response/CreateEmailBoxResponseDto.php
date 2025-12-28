<?php

namespace App\DTO\Response;

use App\Entity\TemporaryEmailBox;
use Symfony\Component\Uid\Uuid;

class CreateEmailBoxResponseDto
{
    public function __construct(
        public string $email,
        public Uuid $uuid,
    ) {
    }

    public static function fromEntity(TemporaryEmailBox $temporaryEmailBox): self
    {
        return new self(
            email: $temporaryEmailBox->getEmail(),
            uuid: $temporaryEmailBox->getUuid(),
        );
    }
}
