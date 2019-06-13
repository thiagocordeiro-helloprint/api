<?php declare(strict_types=1);

namespace App\HelloPrint\Auth;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;

class ResetPasswordService
{
    private AuthApi $apiClient;

    public function __construct(AuthApi $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function requestPasswordReset(string $email): void
    {
        $this->apiClient->resetPassword($email);
    }
}
