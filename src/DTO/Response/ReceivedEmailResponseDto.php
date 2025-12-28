<?php

namespace App\DTO\Response;

use App\Entity\ReceivedEmail;

class ReceivedEmailResponseDto
{
    public function __construct(
        public string $real_from,
        public string $real_to,
        public ?string $from_name,
        public ?string $from_address,
        public array $to_multiple,
        public string $subject,
        public ?string $html,
        public \DateTimeImmutable $receivedAt,
    ) {
    }

    public static function fromEntity(ReceivedEmail $email): self
    {
        return new self(
            real_from: $email->getRealFrom(),
            real_to: $email->getRealTo(),
            from_name: $email->getFromName(),
            from_address: $email->getFromAddress(),
            to_multiple: $email->getToMultiple(),
            subject: $email->getSubject() ?? '(no subject)',
            html: $email->getHtml(),
            receivedAt: $email->getCreatedAt() ?? new \DateTimeImmutable(),
        );
    }
}
