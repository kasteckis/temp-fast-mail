<?php

namespace App\DTO\Response;

use App\Entity\ReceivedEmail;

class ReceivedEmailResponseListDto
{
    public function __construct(
        public string $uuid,
        public string $real_from,
        public string $real_to,
        public ?string $from_name,
        public string $subject,
        public \DateTimeImmutable $received_at,
    ) {
    }

    public static function fromEntity(ReceivedEmail $email): self
    {
        return new self(
            uuid: $email->getUuid(),
            real_from: $email->getRealFrom(),
            real_to: $email->getRealTo(),
            from_name: $email->getFromName(),
            subject: $email->getSubject() ?? '(no subject)',
            received_at: $email->getCreatedAt() ?? new \DateTimeImmutable(),
        );
    }
}
