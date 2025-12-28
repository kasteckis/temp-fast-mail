<?php

namespace App\Service\Validator\ReceivedEmail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CreateReceivedEmailAuthValidator
{
    public function validate(Request $request): void
    {
        if ($request->headers->get('Authorization') === $_ENV['CREATE_RECEIVED_EMAIL_API_AUTHORIZATION_KEY']) {
            return;
        }

        throw new UnauthorizedHttpException('Bad authorization KEY');
    }
}
