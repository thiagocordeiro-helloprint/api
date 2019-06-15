<?php declare(strict_types=1);

namespace App\HelloPrint\Auth;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\Exception\UserNotFoundException;

class ResetPasswordService
{
    private PasswordReseter $apiClient;

    public function __construct(PasswordReseter $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @throws UserNotFoundException
     * @throws ServiceUnavailableException
     */
    public function requestPasswordReset(string $email): void
    {
        $this->apiClient->resetPassword($email);
    }
}
