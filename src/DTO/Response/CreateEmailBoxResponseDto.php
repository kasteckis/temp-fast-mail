<?php

namespace App\DTO\Response;

use App\Entity\TemporaryEmailBox;

class CreateEmailBoxResponseDto
{
    public function __construct(
        public string $email,
        public string $uuid,
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
