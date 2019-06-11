<?php declare(strict_types=1);

namespace App\HelloPrint\Service\Authentication;

use App\HelloPrint\Entity\User;
use App\HelloPrint\Exception\UserNotFoundByEmailException;
use App\HelloPrint\Service\UuidCreator;

class ResetPassword
{
    private UuidCreator $uuidCreator;

    private PasswordResetLinkCreator $linkCreator;

    private UserLoader $userLoader;

    public function __construct(UuidCreator $uuidCreator, PasswordResetLinkCreator $linkCreator, UserLoader $userLoader)
    {
        $this->uuidCreator = $uuidCreator;
        $this->linkCreator = $linkCreator;
        $this->userLoader = $userLoader;
    }

    public function reset(string $email): string
    {
        $user = $this->userLoader->loadByEmail($email);

        if (!is_a($user, User::class)) {
            throw new UserNotFoundByEmailException();
        }

        $uuid = $this->uuidCreator->create();

        $this->linkCreator->createByEmail($email, $uuid);

        return $uuid;
    }
}
