<?php declare(strict_types=1);

namespace App\HelloPrint\Service\Authentication;

interface PasswordResetLinkCreator
{
    public function createByEmail(string $email, string $uuid): string;
}
