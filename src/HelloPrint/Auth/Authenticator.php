<?php declare(strict_types=1);

namespace App\HelloPrint\Auth;

use App\HelloPrint\Auth\Exception\ServiceUnavailableException;
use App\HelloPrint\Auth\Exception\UserNotFoundException;

interface Authenticator
{
    /**
     * @throws ServiceUnavailableException
     * @throws UserNotFoundException
     */
    public function authenticate(string $email, string $password): ?User;
}
