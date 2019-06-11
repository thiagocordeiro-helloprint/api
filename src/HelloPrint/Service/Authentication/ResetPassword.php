<?php declare(strict_types=1);

namespace App\HelloPrint\Service\Authentication;

use App\HelloPrint\Service\UuidCreator;

class ResetPassword
{
    private UuidCreator $uuidCreator;

    private PasswordResetLinkCreator $linkCreator;

    public function __construct(UuidCreator $uuidCreator, PasswordResetLinkCreator $linkCreator)
    {
        $this->uuidCreator = $uuidCreator;
        $this->linkCreator = $linkCreator;
    }

    public function reset(string $email): string
    {
        $uuid = $this->uuidCreator->create();

        $this->linkCreator->createByEmail($email, $uuid);

        return $uuid;
    }
}
