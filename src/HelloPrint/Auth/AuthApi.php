<?php

namespace App\HelloPrint\Auth;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;

interface AuthApi
{
    /**
     * @throws ServiceUnavailableException
     */
    public function resetPassword(string $email): void;
}
