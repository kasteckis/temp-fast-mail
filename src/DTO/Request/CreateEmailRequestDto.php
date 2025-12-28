<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;


class CreateEmailRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $real_from,

        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $real_to,

        public readonly ?string $subject,
        public readonly ?string $from_name,
        public readonly ?string $from_address,
        public readonly ?array $to_multiple,
        public readonly ?array $bcc_multiple,
        public readonly ?string $html,
        public readonly ?array $metadata,
    ) {
    }
}
